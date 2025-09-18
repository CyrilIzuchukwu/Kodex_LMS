<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LoginHistory;
use App\Models\Transaction;

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
}
