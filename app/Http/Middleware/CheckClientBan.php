<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ClientBan;

class CheckClientBan
{
    public function handle(Request $request, Closure $next, string $type)
    {
        // $type will be: Student / Faculty / Alumni / Others
        $guard = strtolower($type);

        $user = auth($guard)->user();
        if (!$user) return $next($request);

        $ban = ClientBan::where('client_type', $type)
            ->where('client_id', $user->id)
            ->first();

        if (!$ban) return $next($request);

        // permanent
        if ((int)$ban->is_permanent === 1) {
            auth($guard)->logout();
            return redirect()->route('client.login', $guard)
                ->withErrors(['email' => 'Your account is permanently banned.']);
        }

        // temporary
        if (!empty($ban->banned_until) && now()->lt($ban->banned_until)) {
            $until = \Carbon\Carbon::parse($ban->banned_until)->format('Y-m-d h:i A');
            auth($guard)->logout();

            return redirect()->route('client.login', $guard)
                ->withErrors(['email' => "Your account is temporarily banned until {$until}."]);
        }

        return $next($request);
    }
}