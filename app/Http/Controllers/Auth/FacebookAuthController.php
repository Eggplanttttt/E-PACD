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
            if (session('facebook_password_reset')) {
                session()->forget([
                    'facebook_password_reset',
                    'facebook_reset_verified',
                    'reset_email',
                    'client_type',
                ]);

                return redirect()->route('others.password.forgot')
                    ->withErrors(['facebook' => 'Facebook confirmation failed. Please try again.']);
            }

            return redirect('/inquiries')
                ->with('error', 'Facebook login failed. Please try again.');
        }

        if (!$fbUser->getEmail()) {
            if (session('facebook_password_reset')) {
                session()->forget([
                    'facebook_password_reset',
                    'facebook_reset_verified',
                    'reset_email',
                    'client_type',
                ]);

                return redirect()->route('others.password.forgot')
                    ->withErrors(['facebook' => 'Facebook did not provide an email address.']);
            }

            return redirect('/inquiries')
                ->with('error', 'Facebook did not provide an email.');
        }

        $email = $fbUser->getEmail();
        $fbId  = $fbUser->getId();

        /**
         * FORGOT PASSWORD FLOW
         */
        if (session('facebook_password_reset') && session('client_type') === 'others') {
            $others = Other::where('email', $email)->first();

            if (!$others) {
                session()->forget([
                    'facebook_password_reset',
                    'facebook_reset_verified',
                    'reset_email',
                    'client_type',
                ]);

                return redirect()->route('others.password.forgot')
                    ->withErrors(['facebook' => 'No "others" account matched your Facebook email.']);
            }

            if (!$others->fb_verified || !$others->fb_id) {
                session()->forget([
                    'facebook_password_reset',
                    'facebook_reset_verified',
                    'reset_email',
                    'client_type',
                ]);

                return redirect()->route('others.password.forgot')
                    ->withErrors(['facebook' => 'This account is not linked to Facebook for password recovery.']);
            }

            if ((string) $others->fb_id !== (string) $fbId) {
                session()->forget([
                    'facebook_password_reset',
                    'facebook_reset_verified',
                    'reset_email',
                    'client_type',
                ]);

                return redirect()->route('others.password.forgot')
                    ->withErrors(['facebook' => 'The Facebook account does not match this registered account.']);
            }

            session([
                'reset_email' => $email,
                'facebook_reset_verified' => true,
            ]);

            session()->forget([
                'facebook_password_reset',
                'client_type',
            ]);

            return redirect()->route('others.password.reset.form')
                ->with('success', 'Facebook confirmed. You can now reset your password.');
        }

        /**
         * NORMAL REGISTRATION FLOW
         */
        $alreadyRegistered =
            Student::where('email', $email)->exists() ||
            Faculty::where('email', $email)->exists() ||
            Alumni::where('email', $email)->exists() ||
            Other::where('email', $email)->exists();

        if ($alreadyRegistered) {
            session()->forget([
                'fb_verified_others',
                'fb_email',
                'fb_name',
                'fb_id',
                'fb_avatar'
            ]);

            return redirect('/inquiries')
                ->withErrors(['email' => 'This Facebook email is already registered. Please log in instead.']);
        }

        // Store FB data in session for the registration form
        session([
            'fb_verified_others' => true,
            'fb_email'           => $email,
            'fb_name'            => $fbUser->getName(),
            'fb_id'              => $fbUser->getId(),
            'fb_avatar'          => $fbUser->getAvatar(),
        ]);

        return redirect()->to(url('/inquiries?open=others-register&clientType=others'));
    }
}
