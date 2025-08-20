<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoursePayment;
use Illuminate\Http\Request;

class ManagePaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payments.index', [
            'title' => 'Course Payments'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CoursePayment $coursePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoursePayment $coursePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoursePayment $coursePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoursePayment $coursePayment)
    {
        //
    }
}
