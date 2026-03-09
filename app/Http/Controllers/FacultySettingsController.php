<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FacultySettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:faculty'); // faculty-only
    }

    /**
     * Show the faculty settings page.
     */
    public function index()
    {
        return view('settings.faculty_settings'); // resources/views/settings/faculty_settings.blade.php
    }

    /**
     * Update the logged-in faculty's password.
     */
    public function updatePassword(Request $request)
    {
        $faculty = Auth::guard('faculty')->user();

        if (!$faculty) {
            return back()->with('error', 'Unable to identify authenticated faculty.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $faculty->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        \DB::table('faculty')
            ->where('id', $faculty->id)
            ->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully.');
    }
}
