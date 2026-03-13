<?php

namespace App\Http\Controllers;

use App\Models\Other;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class OthersPasswordController extends Controller
{
    /**
     * Step 1: Start Facebook confirmation for password reset
     */
    public function verifyEmail(Request $request)
    {
        return $this->redirectToFacebook();
    }

    public function redirectToFacebook()
    {
        session([
            'facebook_password_reset' => true,
            'client_type' => 'others',
        ]);

       return Socialite::driver('facebook')
            ->redirectUrl(route('facebook.callback'))
            ->scopes(['email'])
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        if (!session('facebook_password_reset')) {
            return redirect()->route('others.password.forgot')
                ->withErrors(['facebook' => 'Please start the password reset process again.']);
        }

        try {
           $fbUser = Socialite::driver('facebook')
                ->redirectUrl(route('facebook.callback'))
                ->stateless()
                ->user();
        } catch (\Throwable $e) {
            session()->forget(['facebook_password_reset']);

            return redirect()->route('others.password.forgot')
                ->withErrors(['facebook' => 'Facebook confirmation failed. Please try again.']);
        }

        $email = $fbUser->getEmail();
        $fbId = $fbUser->getId();

        if (!$email || !$fbId) {
            session()->forget(['facebook_password_reset']);

            return redirect()->route('others.password.forgot')
                ->withErrors(['facebook' => 'Facebook did not return enough account details.']);
        }

        $others = Other::where('email', $email)->first();

        if (!$others) {
            session()->forget(['facebook_password_reset']);

            return redirect()->route('others.password.forgot')
                ->withErrors(['facebook' => 'No "others" account matched your Facebook email.']);
        }

        if (!$others->fb_verified || !$others->fb_id) {
            session()->forget(['facebook_password_reset']);

            return redirect()->route('others.password.forgot')
                ->withErrors(['facebook' => 'This account is not linked to Facebook for password recovery.']);
        }

        if ((string) $others->fb_id !== (string) $fbId) {
            session()->forget(['facebook_password_reset']);

            return redirect()->route('others.password.forgot')
                ->withErrors(['facebook' => 'The Facebook account does not match this registered account.']);
        }

        session([
            'reset_email' => $email,
            'facebook_reset_verified' => true,
        ]);

        session()->forget(['facebook_password_reset']);

        return redirect()->route('others.password.reset.form')
            ->with('success', 'Facebook confirmed. You can now reset your password.');
    }

    /**
     * Legacy OTP endpoint redirected to the new Facebook flow
     */
    public function verifyOtp(Request $request)
    {
        return redirect()->route('others.password.forgot')
            ->withErrors(['facebook' => 'OTP is no longer used. Please confirm with Facebook instead.']);
    }

    /**
     * Step 2: Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
        'password' => [
            'required',
            'string',
            'min:8', 
            'confirmed',
            'regex:/[A-Z]/',      
            'regex:/[0-9]/',     
            'regex:/[@$!%*?&]/', 
        ],
    ]);


        $email = session('reset_email');

        if (!session('facebook_reset_verified') || !$email) {
            return redirect()->route('others.password.forgot')
                ->withErrors(['facebook' => 'You must confirm your account with Facebook first.']);
        }

        $others = Other::where('email', $email)->first();

        if (!$others) {
            return redirect()->route('others.password.forgot')
                ->withErrors(['email' => 'Other not found.']);
        }

        $others->password = Hash::make($request->password);
        $others->save();

        // Clear session after reset
        session()->forget([
            'reset_email',
            'reset_otp',
            'otp_verified',
            'reset_otp_sent',
            'otp_created_at',
            'facebook_password_reset',
            'facebook_reset_verified',
        ]);

        return redirect()->route('client.login', ['clientType' => 'others'])
            ->with('success', 'Password reset successfully. Please login.');
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        return redirect()->route('others.password.forgot');
    }

    /**
     * Show password reset form
     */
    public function showResetForm()
    {
        if (!session('facebook_reset_verified')) {
            return redirect()->route('others.password.forgot');
        }

        return view('auth.others-reset-password'); // Blade for new password
    }

    public function showForgotPasswordForm()
    {
        // Always reset the flow when user clicks "Forgot Password"
        session()->forget([
            'reset_email',
            'reset_otp',
            'otp_verified',
            'reset_otp_sent',
            'otp_created_at',
            'facebook_password_reset',
            'facebook_reset_verified',
        ]);

        return view('auth.others-forgot-password');
    }

}
