<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Faculty;
use App\Models\Other;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OthersProfileController extends Controller
{
    public function store(Request $request)
    {
        // Must be verified first
        if (!session('fb_verified_others') || !session('fb_email')) {
            return redirect('/inquiries')
                ->with('error', 'Session expired. Please verify Facebook again.');
        }

        // Validate form fields
        $request->validate([
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_initial'  => ['nullable', 'string', 'max:20'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:10'],
            'address'         => ['required', 'string', 'max:255'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'email'           => ['required', 'email'], // hidden email input
        ]);

        // Source of truth for FB identity
        $email  = session('fb_email');
        $fbId   = session('fb_id');
        $avatar = session('fb_avatar');

        if (!$fbId) {
            return redirect('/inquiries')
                ->with('error', 'Facebook session expired. Please verify again.');
        }

        // fallback (DB requires not null)
        if (!$avatar) {
            $avatar = 'default-avatar.png';
        }

        // Block duplicate account creation across all client types.
        $alreadyRegistered =
            Student::where('email', $email)->exists() ||
            Faculty::where('email', $email)->exists() ||
            Alumni::where('email', $email)->exists() ||
            Other::where('email', $email)->exists();

        if ($alreadyRegistered) {
            return redirect('/inquiries')
                ->withErrors(['email' => 'This email is already registered. Please log in instead.'])
                ->withInput();
        }

        $other = new Other();

        // Fill profile fields
        $other->email          = $email;
        $other->first_name     = $request->first_name;
        $other->middle_initial = $request->middle_initial;
        $other->last_name      = $request->last_name;
        $other->suffix         = $request->suffix;
        $other->address        = $request->address;

        // Required fields in your DB
        $other->client_type = 'others';
        $other->fb_id       = (string) $fbId;   // keep as string (FB ids are huge)
        $other->fb_avatar   = $avatar;
        $other->fb_verified = 1;

        // Password
        $other->password = Hash::make($request->password);

        $other->save();

        // Clear FB session flags
        session()->forget(['fb_verified_others', 'fb_email', 'fb_name', 'fb_id', 'fb_avatar']);

        return redirect('/inquiries?skipModal=1')
            ->with('success', 'Registration completed successfully!');
    }
}
