<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageStudentsControllers extends Controller
{
    public function index()
    {
        return view('admin.students.index', [
            'title' => 'Students',
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
