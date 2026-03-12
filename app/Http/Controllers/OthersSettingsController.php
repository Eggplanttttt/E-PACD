<?php

namespace App\Http\Controllers;

use App\Models\Other;
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

    public function updateProfile(Request $request)
    {
        /** @var Other|null $other */
        $other = Auth::guard('others')->user();

        if (!$other) {
            return back()->with('error', 'Unable to identify authenticated user.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:20',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'address' => 'required|string|max:255',
            'contact_number' => 'nullable|string|regex:/^09\d{9}$/',
        ]);

        $other->first_name = $validated['first_name'];
        $other->middle_initial = $validated['middle_initial'] ?: null;
        $other->last_name = $validated['last_name'];
        $other->suffix = $validated['suffix'] ?: null;
        $other->address = $validated['address'];
        $other->contact_number = $validated['contact_number'] ?: null;
        $other->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the logged-in other's password.
     */
    public function updatePassword(Request $request)
    {
        /** @var Other|null $other */
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
