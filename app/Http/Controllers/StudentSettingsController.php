<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student'); // student-only
    }

    /**
     * Show the student settings page.
     */
    public function index()
    {
        return view('settings.student_settings'); // e.g., resources/views/settings/student.blade.php
    }

    /**
     * Update the logged-in student's password.
     */
    public function updatePassword(Request $request)
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return back()->with('error', 'Unable to identify authenticated student.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $student->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        \DB::table('students')
            ->where('id', $student->id)
            ->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully.');
    }
}
