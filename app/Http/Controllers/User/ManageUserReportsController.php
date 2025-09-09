<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
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
}
