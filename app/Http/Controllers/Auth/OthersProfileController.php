<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Faculty;
use App\Models\Other;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'email'           => ['required', 'email'],
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

        $nameParts = $this->splitFacebookName(session('fb_name'), $email);

        $other = new Other();
        $other->email          = $email;
        $other->first_name     = $nameParts['first_name'];
        $other->middle_initial = $nameParts['middle_initial'];
        $other->last_name      = $nameParts['last_name'];
        $other->suffix         = $nameParts['suffix'];
        $other->address        = '';

        // Required fields in your DB
        $other->client_type = 'others';
        $other->fb_id       = (string) $fbId;   // keep as string (FB ids are huge)
        $other->fb_avatar   = $avatar;
        $other->fb_verified = 1;

        // Password
        $other->password = Hash::make($request->password);

        $other->save();

        Auth::guard('others')->login($other);
        session([
            'client_type' => 'others',
            'client_id' => $other->id,
        ]);

        // Clear FB session flags
        session()->forget(['fb_verified_others', 'fb_email', 'fb_name', 'fb_id', 'fb_avatar']);

        return redirect()->route('client.dashboard.others')
            ->with('success', 'Registration completed successfully!');
    }

    protected function splitFacebookName(?string $name, string $email): array
    {
        $name = trim((string) $name);

        if ($name !== '') {
            $parts = preg_split('/\s+/', $name) ?: [];

            return [
                'first_name' => $parts[0] ?? 'Facebook',
                'middle_initial' => count($parts) > 2 ? implode(' ', array_slice($parts, 1, -1)) : null,
                'last_name' => count($parts) > 1 ? $parts[count($parts) - 1] : 'User',
                'suffix' => null,
            ];
        }

        $emailPrefix = (string) strtok($email, '@');
        $fallbackName = trim(ucwords(str_replace(['.', '_', '-'], ' ', $emailPrefix)));

        return [
            'first_name' => $fallbackName !== '' ? $fallbackName : 'Facebook',
            'middle_initial' => null,
            'last_name' => 'User',
            'suffix' => null,
        ];
    }
}
