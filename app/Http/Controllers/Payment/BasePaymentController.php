<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Mail\CoursePurchasedConfirmation;
use App\Models\CartItem;
use App\Models\CourseEnrollment;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\CoursePurchasedNotification;
use App\Notifications\NewCoursePurchased;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use RuntimeException;
use Throwable;

abstract class BasePaymentController extends Controller
{
    /**
     * @param int $id
     * @return Transaction
     */
    protected function getPaymentOrFail(int $id): Transaction
    {
        $payment = Transaction::where('id', $id)->first();

        if (!$payment) {
            throw new RuntimeException('Transaction not found.');
        }

        return $payment;
    }

    /**
     * @param array $transactionDetails
     * @return void
     */
    protected function updateTransactionRecord(array $transactionDetails): void
    {
        Transaction::where('id', $transactionDetails['payment_id'])->update([
            'channel' => $transactionDetails['channel'],
            'transaction_reference' => $transactionDetails['reference'],
            'status' => 'completed',
        ]);
    }

    /**
     * Handle response for a successful payment.
     *
     * @param Transaction $payment
     * @return RedirectResponse
     * @throws Throwable
     */
    protected function successfulPaymentResponse(Transaction $payment): RedirectResponse
    {
        // Show confetti
        session()->flash('show_confetti');

        // Remove items from cart
        DB::beginTransaction();

        try {
            // Get Authenticated User
            $user = Auth::user();

            // Store Enrolled Courses
            $items = CartItem::where('user_id', $user->id)->get();
            foreach ($items as $item) {
                if (!empty($item->course_id)) {
                    $course = $item->course;
                    $firstModule = $course->modules ? $course->modules->first() : null;
                    CourseEnrollment::create([
                        'course_id' => $item->course_id,
                        'user_id' => $user->id,
                        'module_id' => $firstModule->id,
                    ]);
                } else {
                    Log::warning('Invalid course_id in CartItem', ['cart_item_id' => $item->id]);
                }
            }

            // Delete all cart items for the user
            CartItem::where('user_id', $user->id)->delete();

            // Clear coupons and discounts sessions after successful cart item removal
            session()->forget(['applied_coupon', 'discount']);

            // Send email if email notifications are enabled
            $emailSettings = email_settings();
            if (($emailSettings?->status ?? config('settings.email_notification')) && $user->email) {
                Mail::mailer($emailSettings?->provider ?? config('settings.email_provider'))
                    ->to($user->email)
                    ->send(new CoursePurchasedConfirmation($payment));

                // Notify user
                Notification::send(User::where('id', Auth::id())->get(), new CoursePurchasedNotification($payment));

                // Notify all admins
                Notification::send(User::where('role', 'admin')->get(), new NewCoursePurchased($payment));
            }

            DB::commit();

            return redirect()->route('user.payment.success', [
                'payment' => $payment->id,
            ])->with('success', 'Your course purchase has been successfully processed.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment processing failed', ['error' => $e->getMessage()]);
            return redirect()->route('user.payment.error', [
                'payment' => $payment->id,
            ])->with('error', 'An error occurred while processing your course purchase. Please try again or contact support.');
        }
    }
}
