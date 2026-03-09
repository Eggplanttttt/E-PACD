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

        return response()->make("
            <script>
                if (window.opener) {
                    window.opener.postMessage({ google_email: " . json_encode($email) . " }, '*');
                    window.close();
                } else {
                    document.body.innerHTML = 'Google login succeeded, but no opener window found.';
                }
            </script>
        ");
    } catch (\Throwable $e) {
        return response()->make("
            <h2>Google Callback Error</h2>
            <pre>" . e($e->getMessage()) . "</pre>
        ", 500);
    }
}
}
