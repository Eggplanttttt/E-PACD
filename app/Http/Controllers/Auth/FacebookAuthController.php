<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Faculty;
use App\Models\Other;
use App\Models\Student;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    public function redirect()
    {
        session(['client_type' => request('clientType', 'others')]);

        return Socialite::driver('facebook')
            ->scopes(['email'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->stateless()->user();
        } catch (\Throwable $e) {
            return redirect('/inquiries')
                ->with('error', 'Facebook login failed. Please try again.');
        }

        if (!$fbUser->getEmail()) {
            return redirect('/inquiries')
                ->with('error', 'Facebook did not provide an email.');
        }

        $email = $fbUser->getEmail();

        // Stop here if this Facebook email is already registered.
        $alreadyRegistered =
            Student::where('email', $email)->exists() ||
            Faculty::where('email', $email)->exists() ||
            Alumni::where('email', $email)->exists() ||
            Other::where('email', $email)->exists();

        if ($alreadyRegistered) {
            session()->forget(['fb_verified_others', 'fb_email', 'fb_name', 'fb_id', 'fb_avatar']);

            return redirect('/inquiries')
                ->withErrors(['email' => 'This Facebook email is already registered. Please log in instead.']);
        }

        // store FB data in session for the registration form
        session([
            'fb_verified_others' => true,
            'fb_email' => $email,
            'fb_name'  => $fbUser->getName(),
            'fb_id'    => $fbUser->getId(),
            'fb_avatar'=> $fbUser->getAvatar(),
        ]);

        return redirect()->to(url('/inquiries?open=others-register&clientType=others'));
    }
}
