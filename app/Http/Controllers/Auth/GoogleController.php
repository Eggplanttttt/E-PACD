<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('clientType')) {
            session(['clientType' => $request->clientType]);
        }

        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $email = $googleUser->getEmail();

            $safeEmail = json_encode($email);

            return response("
                <script>
                    if (window.opener) {
                        window.opener.postMessage({ google_email: {$safeEmail} }, '*');
                        window.close();
                    } else {
                        document.body.innerHTML = 'Google login succeeded, but no opener window was found.';
                    }
                </script>
            ");
        } catch (\Throwable $e) {
            return response("
                <script>
                    alert('Failed to fetch Google email: " . addslashes($e->getMessage()) . "');
                    window.close();
                </script>
            ", 500);
        }
    }
}
