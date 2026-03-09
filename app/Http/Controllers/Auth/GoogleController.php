<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('clientType')) {
            session(['clientType' => $request->clientType]);
        }
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $email = $googleUser->getEmail();

            return response()->make("
                <script>
                    if (window.opener) {
                        window.opener.postMessage({ google_email: '$email' }, '*');
                        window.close();
                    } else {
                        alert('No opener window found.');
                    }
                </script>
            ");
        } catch (\Exception $e) {
            return "<script>alert('Failed to fetch Google email'); window.close();</script>";
        }
    }
}
