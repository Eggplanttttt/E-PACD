<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OthersSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:others'); // others-only
    }

    /**
     * Show the others settings page.
     */
    public function index()
    {
        return view('settings.others_settings'); // resources/views/settings/others_settings.blade.php
    }

    /**
     * Update the logged-in other's password.
     */
    public function updatePassword(Request $request)
    {
        $other = Auth::guard('others')->user();

        if (!$other) {
            return back()->with('error', 'Unable to identify authenticated user.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $other->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        \DB::table('others')
            ->where('id', $other->id)
            ->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully.');
    }
}
