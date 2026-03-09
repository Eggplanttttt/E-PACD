<?php

namespace App\Http\Controllers;

use App\Models\Other;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetOtp;

class OthersPasswordController extends Controller
{
    /**
     * Step 1: Verify email and send OTP
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        if (!str_ends_with($request->email, '@gmail.com')) {
            return back()->withErrors(['email' => 'Invalid email.']);
        }

        $others = Other::where('email', $request->email)->first();

        if (!$others) {
            return back()->withErrors(['email' => 'Email is not registered.']);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP and email in session (valid for 10 min)
        session([
            'reset_email' => $request->email,
            'reset_otp' => $otp,
            'otp_created_at' => now(),
            'reset_otp_sent' => true // mark OTP as sent
        ]);

        // Send OTP email
        Mail::to($request->email)->send(new PasswordResetOtp($otp));

         return redirect()->route('others.password.otp.form')
    ->with('success', 'An OTP has been sent to your email. Please check your inbox.');
    }

    /**
     * Step 2: Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $otp = session('reset_otp');
        $createdAt = session('otp_created_at');

        if (!$otp) {
            return redirect()->route('others.password.forgot')
                ->withErrors(['otp' => 'No OTP found. Please request again.']);
        }

        // Check OTP expiration (10 min)
        if (now()->diffInMinutes($createdAt) > 10) {
            session()->forget(['reset_email', 'reset_otp', 'reset_otp_sent']);
            return redirect()->route('others.password.forgot')
                ->withErrors(['otp' => 'OTP expired. Please request a new one.']);
        }

        if ($request->otp != $otp) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // OTP is correct
        session(['otp_verified' => true]);

        return redirect()->route('others.password.reset.form')
            ->with('success', 'OTP verified. You can now reset your password.');
    }

    /**
     * Step 3: Reset password
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

        if (!session('otp_verified') || !$email) {
            return redirect()->route('others.password.forgot')
                ->withErrors(['email' => 'You must verify your email with OTP first.']);
        }

        $others = Other::where('email', $email)->first();

        if (!$others) {
            return redirect()->route('others.password.forgot')
                ->withErrors(['email' => 'Other not found.']);
        }

        $others->password = Hash::make($request->password);
        $others->save();

        // Clear session after reset
        session()->forget(['reset_email', 'reset_otp', 'otp_verified', 'reset_otp_sent']);

        return redirect()->route('client.login', ['clientType' => 'others'])
            ->with('success', 'Password reset successfully. Please login.');
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        if (!session('reset_otp_sent')) {
            return redirect()->route('others.password.forgot');
        }

        return view('auth.others-otp'); // Blade for OTP input
    }

    /**
     * Show password reset form
     */
    public function showResetForm()
    {
        if (!session('otp_verified')) {
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
        ]);

        return view('auth.others-forgot-password');
    }

}
