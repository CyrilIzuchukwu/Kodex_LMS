<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function __invoke()
    {
        $courses = Course::with(['category', 'profile.user'])
            ->orderBy('title', 'ASC')
            ->latest()
            ->limit(3)->get();

        return view('user.dashboard', [
            'title' => 'Dashboard',
            'courses' => $courses
        ]);
    }
}
