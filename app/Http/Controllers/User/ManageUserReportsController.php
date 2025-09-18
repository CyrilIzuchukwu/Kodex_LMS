<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LoginHistory;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ManageUserReportsController extends Controller
{
    public function logins()
    {
        $loginHistories = LoginHistory::where('user_id', Auth::id())
            ->orderBy('login_at', 'desc')
            ->paginate(10);

        return view('user.reports.login-history', [
            'title' => 'Login History',
            'loginHistories' => $loginHistories
        ]);
    }

    public function transactions()
    {
        // Fetch transactions for the authenticated user
        $payments = Transaction::where('user_id', Auth::id())->paginate(10);

        // Collect all course IDs from cart_items across all transactions
        $courseIds = [];
        foreach ($payments as $payment) {
            $cartItems = json_decode($payment->cart_items, true) ?? [];
            $courseIds = array_merge($courseIds, array_column($cartItems, 'course_id'));
        }
        $courseIds = array_unique($courseIds);

        // Fetch Course models for the collected course IDs
        $courses = Course::whereIn('id', $courseIds)->with('category')->get();

        $completed_payments = Transaction::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->sum('amount');

        $payments_this_month = Transaction::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $purchased_courses_count = Transaction::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->get()
            ->sum(function ($transaction) {
                $items = json_decode($transaction->cart_items, true) ?? [];
                return count($items);
            });

        return view('user.reports.transactions', [
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
        $user_id = Auth::id();

        // Decode cart items and fetch the courses
        $cartItems = json_decode($transaction->cart_items, true) ?? [];
        $courseIds = array_column($cartItems, 'course_id');
        $courses = Course::whereIn('id', $courseIds)->with('category')->get();

        // Get unique category IDs from the cart courses
        $categoryIds = $courses->pluck('category_id')->unique()->toArray();

        // Fetch related courses from the same categories, excluding the cart courses
        $relatedCourses = Course::with(['category', 'profile.user'])
            ->inRandomOrder()
            ->whereIn('category_id', $categoryIds)
            ->whereNotIn('id', $courseIds)
            ->whereNotIn('id', function ($query) use ($user_id) {
                $query->select('course_id')
                    ->from('course_enrollments')
                    ->where('user_id', $user_id);
            })
            ->orderBy('title', 'ASC')
            ->latest()
            ->limit(2)
            ->get();

        return view('user.payments.success', [
            'title' => 'Payment Successful',
            'errorMessage' => 'Your payment for the course was successfully processed! You now have access to your course. Check your email for confirmation and access details.',
            'txRef' => $transaction->transaction_reference,
            'payment' => $transaction,
            'retry' => true,
            'courses' => $courses,
            'relatedCourses' => $relatedCourses,
        ]);
    }
}
