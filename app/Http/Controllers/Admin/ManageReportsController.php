<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CoursePurchasedConfirmation;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\LoginHistory;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\CoursePurchasedNotification;
use App\Notifications\NewCoursePurchased;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Str;
use Throwable;

class ManageReportsController extends Controller
{
    public function logins()
    {
        $loginHistories = LoginHistory::query()
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->orderBy('login_at', 'desc')
            ->paginate(10);

        return view('admin.reports.login-history', [
            'title' => 'Login History',
            'loginHistories' => $loginHistories
        ]);
    }

    public function transactions()
    {
        // Fetch transactions for the authenticated user
        $payments = Transaction::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Collect all course IDs from cart_items across all transactions
        $courseIds = [];
        foreach ($payments as $payment) {
            $cartItems = json_decode($payment->cart_items, true) ?? [];
            $courseIds = array_merge($courseIds, array_column($cartItems, 'course_id'));
        }
        $courseIds = array_unique($courseIds);

        // Fetch Course models for the collected course IDs
        $courses = Course::whereIn('id', $courseIds)->with('category')->get();

        $completed_payments = Transaction::where('status', 'completed')
            ->sum('amount');

        $payments_this_month = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $purchased_courses_count = Transaction::where('status', 'completed')
            ->get()
            ->sum(function ($transaction) {
                $items = json_decode($transaction->cart_items, true) ?? [];
                return count($items);
            });

        return view('admin.reports.transactions', [
            'title' => 'Transactions',
            'payments' => $payments,
            'courses' => $courses,
            'completed_payments' => $completed_payments,
            'payments_this_month' => $payments_this_month,
            'purchased_courses_count' => $purchased_courses_count
        ]);
    }

    public function showTransaction(Transaction $transaction)
    {
        // Decode cart items and fetch the courses
        $cartItems = json_decode($transaction->cart_items, true) ?? [];
        $courseIds = array_column($cartItems, 'course_id');
        $courses = Course::whereIn('id', $courseIds)->with('category')->get();

        return view('admin.reports.show-transaction', [
            'title' => 'Transaction History',
            'payment' => $transaction,
            'courses' => $courses
        ]);
    }

    /**
     * Approve a transaction and enroll the user in purchased courses.
     *
     * @param Transaction $transaction
     * @return RedirectResponse
     * @throws Throwable
     */
    public function approveTransaction(Transaction $transaction)
    {
        // Validate transaction state
        if ($transaction->status === 'completed') {
            return redirect()->back()->with('error', 'This transaction has already been processed.');
        }

        DB::beginTransaction();

        try {

            // Decode cart items and fetch the courses
            $cartItems = json_decode($transaction->cart_items, true) ?? [];
            if (empty($cartItems)) {
                throw new Exception('No cart items found in the transaction.');
            }

            $courseIds = array_column($cartItems, 'course_id');
            $courses = Course::whereIn('id', $courseIds)->with('modules')->get();

            if ($courses->isEmpty()) {
                throw new Exception('No valid courses found for the transaction.');
            }

            // Enroll user in each course
            foreach ($courses as $course) {
                $firstModule = $course->modules->first();
                if (!$firstModule) {
                    continue;
                }

                // Check for existing enrollment for this user and course
                $existingEnrollment = CourseEnrollment::where('course_id', $course->id)
                    ->where('user_id', $transaction->user_id)
                    ->exists();

                if (!$existingEnrollment) {
                    CourseEnrollment::create([
                        'course_id' => $course->id,
                        'user_id' => $transaction->user_id,
                        'module_id' => $firstModule->id,
                    ]);
                }
            }

            // Update transaction record
            $transaction->update([
                'channel' => 'Card',
                'transaction_reference' => Str::random(),
                'status' => 'completed',
            ]);

            // Send email and notifications if enabled
            $emailSettings = email_settings();
            if (($emailSettings?->status ?? config('settings.email_notification')) && $transaction->user?->email) {
                try {
                    Mail::mailer($emailSettings?->provider ?? config('settings.email_provider'))
                        ->to($transaction->user->email)
                        ->send(new CoursePurchasedConfirmation($transaction));

                    // Notify user
                    Notification::send($transaction->user, new CoursePurchasedNotification($transaction));

                    // Notify all admins
                    Notification::send(User::where('role', 'admin')->get(), new NewCoursePurchased($transaction));
                } catch (Exception $mailException) {
                    Log::error('Failed to send email/notification for transaction', [
                        'transaction_id' => $transaction->id,
                        'error' => $mailException->getMessage(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Course purchase has been successfully processed.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Transaction approval failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while processing your course purchase. Please try again or contact support.');
        }
    }

    /**
     * Cancel a transaction.
     *
     * @param Transaction $transaction
     * @return RedirectResponse
     * @throws Throwable
     */
    public function cancelTransaction(Transaction $transaction)
    {
        // Validate transaction state
        if ($transaction->status === 'cancelled') {
            return redirect()->back()->with('error', 'This transaction has already been cancelled.');
        }

        if ($transaction->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot cancel a completed transaction.');
        }

        DB::beginTransaction();

        try {

            // Update transaction record
            $transaction->update([
                'channel' => 'Card',
                'transaction_reference' => Str::random(),
                'status' => 'cancelled',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Transaction has been successfully cancelled.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Transaction cancellation failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while cancelling the transaction. Please try again or contact support.');
        }
    }

    /**
     * @throws Throwable
     */
    public function reactivateTransaction(Transaction $transaction)
    {
        // Validate transaction state
        if ($transaction->status !== 'cancelled') {
            return redirect()->back()->with('error', 'Only cancelled transactions can be reactivated.');
        }

        DB::beginTransaction();

        try {
            // Update transaction record
            $transaction->update([
                'channel' => 'Card',
                'transaction_reference' => Str::random(),
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Transaction has been successfully reactivated to pending.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Transaction reactivation failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while reactivating the transaction. Please try again or contact support.');
        }
    }

    /**
     * @throws Throwable
     */
    public function revokeTransaction(Transaction $transaction)
    {
        // Validate transaction state
        if ($transaction->status !== 'completed') {
            return redirect()->back()->with('error', 'Only completed transactions can be reactivated.');
        }

        DB::beginTransaction();

        try {

            // Decode cart items and fetch the courses
            $cartItems = json_decode($transaction->cart_items, true) ?? [];
            $courseIds = array_column($cartItems, 'course_id');
            $courses = Course::whereIn('id', $courseIds)->with('category')->get();

            // Update transaction record to cancelled
            $transaction->update([
                'channel' => 'Card',
                'transaction_reference' => Str::random(),
                'status' => 'cancelled',
            ]);

            // Unenroll user from associated courses
            CourseEnrollment::where('user_id', $transaction->user_id)
                ->whereIn('course_id', $courses->pluck('id'))
                ->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Transaction has been successfully revoked and enrollments removed.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Transaction revocation failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while revoking the transaction. Please try again or contact support.');
        }
    }
}
