<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
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
}
