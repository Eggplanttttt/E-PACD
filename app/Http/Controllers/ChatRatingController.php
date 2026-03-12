<?php

namespace App\Http\Controllers;

use App\Models\ChatRating;
use Illuminate\Http\Request;

class ChatRatingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stars' => ['required', 'integer', 'between:1,5'],
        ]);

        $client = $this->resolveAuthenticatedClient();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to identify authenticated client.',
            ], 401);
        }

        ChatRating::create([
            'client_guard' => $client['guard'],
            'client_type' => ucfirst($client['guard']),
            'client_id' => $client['user']->getKey(),
            'client_name' => $client['name'],
            'client_email' => $client['email'],
            'stars' => $validated['stars'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating submitted successfully.',
        ]);
    }

    private function resolveAuthenticatedClient(): ?array
    {
        foreach (['student', 'faculty', 'alumni', 'others'] as $guard) {
            if (!auth($guard)->check()) {
                continue;
            }

            $user = auth($guard)->user();

            return [
                'guard' => $guard,
                'user' => $user,
                'name' => $this->buildClientName($user),
                'email' => $user->email ?? null,
            ];
        }

        return null;
    }

    private function buildClientName(object $user): string
    {
        $parts = array_filter([
            $user->first_name ?? null,
            $user->middle_initial ?? null,
            $user->last_name ?? null,
            $user->suffix ?? null,
        ]);

        if (!empty($parts)) {
            return trim(implode(' ', $parts));
        }

        return $user->name ?? $user->email ?? 'Unknown Client';
    }
}
