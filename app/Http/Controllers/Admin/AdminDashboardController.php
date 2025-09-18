<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $total_students = User::where('role', 'user')->count();
        $total_instructors = User::where('role', 'instructor')->count();
        $total_courses = Course::count();
        $total_modules = Module::count();
        $total_sign_ups_this_month = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Handle AJAX request for revenue chart data
        if ($request->period) {
            return response()->json($this->getRevenueData($request));
        }

        return view('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'metric' => [
                'total_students' => $total_students,
                'total_instructors' => $total_instructors,
                'total_courses' => $total_courses,
                'total_modules' => $total_modules,
                'total_sign_ups_this_month' => $total_sign_ups_this_month,
            ],
        ]);
    }

    private function getRevenueData(Request $request)
    {
        $period = $request->input('period', 'current_month');
        $query = Transaction::selectRaw("strftime('%m', created_at) as month, SUM(amount) as total");

        // Handle different periods
        if ($period === 'current_month') {
            $query->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month);
        } elseif ($period === 'last_month') {
            $query->whereYear('created_at', now()->subMonth()->year)
                ->whereMonth('created_at', now()->subMonth()->month);
        } elseif ($period === 'last_3_months') {
            $query->where('created_at', '>=', now()->subMonths(3)->startOfMonth());
        } elseif ($period === 'last_6_months') {
            $query->where('created_at', '>=', now()->subMonths(6)->startOfMonth());
        } elseif ($period === 'last_year') {
            $query->whereYear('created_at', now()->subYear()->year);
        } else {
            // Fallback to current year if period is invalid
            $query->whereYear('created_at', now()->year);
        }

        $transactions = $query->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Prepare fixed 12-month labels
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Map totals to each month, defaulting to 0
        $values = [];
        foreach (range(1, 12) as $m) {
            $monthKey = sprintf('%02d', $m);
            $values[] = (float) ($transactions[$monthKey] ?? 0);
        }

        // Set label based on a period
        $label = match ($period) {
            'current_month' => now()->format('F Y'),
            'last_month' => now()->subMonth()->format('F Y'),
            'last_3_months' => 'Last 3 Months',
            'last_6_months' => 'Last 6 Months',
            'last_year' => now()->subYear()->format('Y'),
            default => now()->format('Y'),
        };

        return response()->json([
            'labels' => $months,
            'values' => $values,
            'label' => $label,
        ]);
    }
}
