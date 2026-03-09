<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AlumniSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:alumni'); // alumni-only
    }

    /**
     * Show the alumni settings page.
     */
    public function index()
    {
        return view('settings.alumni_settings'); // resources/views/settings/alumni_settings.blade.php
    }

    /**
     * Update the logged-in alumni's password.
     */
    public function updatePassword(Request $request)
    {
        $alumni = Auth::guard('alumni')->user();

        if (!$alumni) {
            return back()->with('error', 'Unable to identify authenticated alumni.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $alumni->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        \DB::table('alumni')
            ->where('id', $alumni->id)
            ->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully.');
    }
}
