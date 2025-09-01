<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
