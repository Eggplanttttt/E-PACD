<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OthersProfileController extends Controller
{
    public function store(Request $request)
    {
        // Must be verified via facebook
        if (!$request->boolean('fb_verified') && !session('fb_verified_others')) {
            return back()->with('error', 'Please continue with Facebook first.');
        }

        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'middle_initial' => ['nullable','string','max:2'],
            'last_name' => ['required','string','max:100'],
            'suffix' => ['nullable','string','max:10'],
            'address' => ['required','string','max:255'],
            'client_type' => ['required','in:others'],
        ]);

        $user = Auth::user();

        // save to your columns (adjust to your DB)
        $user->firstname = $data['first_name'] ?? $user->firstname;
        $user->middlename = $data['middle_initial'] ?? $user->middlename;
        $user->lastname = $data['last_name'] ?? $user->lastname;
        $user->suffix = $data['suffix'] ?? $user->suffix;
        $user->address = $data['address'] ?? $user->address;
        $user->client_type = 'others';

        // ensure verified because facebook verified
        if (!$user->email_verified_at) $user->email_verified_at = now();

        $user->save();

        // clear the session flag
        session()->forget(['fb_verified_others','fb_email','fb_name']);

        return redirect()->route('inquiries.page')->with('success', 'Registration completed! You can now log in with Facebook anytime.');
    }
}