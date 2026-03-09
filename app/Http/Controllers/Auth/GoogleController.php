<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

            Log::info('Google callback success', ['email' => $email]);

            $safeEmail = json_encode($email);

            return response()->make("
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <title>Google Login Success</title>
                </head>
                <body>
                    <script>
                        (function() {
                            var email = {$safeEmail};

                            if (window.opener && !window.opener.closed) {
                                window.opener.postMessage({ google_email: email }, window.location.origin);
                                window.close();
                            } else {
                                document.body.innerHTML = '<h3>Google login succeeded</h3><p>Email: ' + email + '</p><p>No opener window found.</p>';
                            }
                        })();
                    </script>
                </body>
                </html>
            ", 200, ['Content-Type' => 'text/html']);
        } catch (\Throwable $e) {
            Log::error('Google callback failed: ' . $e->getMessage());

            return response()->make("
                <!DOCTYPE html>
                <html>
                <head><meta charset='UTF-8'><title>Google Login Failed</title></head>
                <body>
                    <script>
                        alert('Failed to fetch Google email.');
                        window.close();
                    </script>
                </body>
                </html>
            ", 500, ['Content-Type' => 'text/html']);
        }
    }
}
