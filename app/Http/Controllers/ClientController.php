<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Facades\Log; // Added for logging

class ClientController extends Controller
{

    public function dashboard()
    {
        if(!Auth::guard('student')->check() &&
        !Auth::guard('faculty')->check() &&
        !Auth::guard('alumni')->check() &&
        !Auth::guard('others')->check()) 
        {
            return redirect()->route('login');
        }

        return response(view('client.dashboard'))  // or dashboard per client type
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Generic method to render dashboards for different client types
     */
    protected function renderDashboard($guard, $view)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect("/login/$guard")->withErrors([
                'unauthorized' => 'Unauthorized access.',
            ]);
        }

        $user     = Auth::guard($guard)->user();
        // Fetch messages from the database for the current user
        $messages = Message::where('client_id', $user->id)
                           ->where('client_type', $guard)
                           ->orderBy('created_at', 'asc') // Ensure the messages are ordered by timestamp
                           ->get();

        return view($view, compact('user', 'messages'));
    }

    /**
     * Student dashboard
     */
    public function studentDashboard()
    {
        return $this->renderDashboard('student', 'client.dashboards.student');
    }

    /**
     * Faculty dashboard
     */
    public function facultyDashboard()
    {
        return $this->renderDashboard('faculty', 'client.dashboards.faculty');
    }

    /**
     * Alumni dashboard
     */
    public function alumniDashboard()
    {
        return $this->renderDashboard('alumni', 'client.dashboards.alumni');
    }

    /**
     * Others dashboard
     */
    public function othersDashboard()
    {
        return $this->renderDashboard('others', 'client.dashboards.others');
    }

    /**
     * Handle sending of messages
     */
    public function sendMessage(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Received message request:', [
            'message' => $request->message,
            'client_type' => $request->client_type
        ]);

        // Validate incoming request
        $request->validate([
            'message' => 'required|string',
            'client_type' => 'required|in:student,faculty,alumni,others',
        ]);

        // Retrieve the client_type and guard based on the provided client_type
        $clientType = $request->input('client_type');
        $guard = in_array($clientType, ['student', 'faculty', 'alumni', 'others']) ? $clientType : null;

        // Ensure a valid user is logged in
        $user = $guard ? Auth::guard($guard)->user() : null;
        if (!$user) {
            Log::error('Unauthorized user attempt to send message.');
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized user.',
            ], 403);
        }

        // Log the user details
        Log::info('Sending message from user: ', [
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        // Store the message in the database
        try {
            $message = Message::create([
                'client_type' => $clientType,
                'client_id' => $user->id,
                'message' => $request->message,
                'sender' => $clientType . '/' . $user->id,
            ]);

            // Log the stored message ID to confirm successful insert
            Log::info('Message stored in database with ID: ' . $message->id);

        } catch (\Exception $e) {
            // Handle any potential errors (e.g., database errors)
            Log::error('Failed to save message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save message: ' . $e->getMessage(),
            ], 500);
        }

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Message saved successfully.',
        ]);
    }

    /**
     * Log out a client based on session client type
     */
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        Auth::guard('faculty')->logout();
        Auth::guard('alumni')->logout();
        Auth::guard('web')->logout(); // optional, for any other guard

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function login(Request $request, $clientType)
    {
        $credentials = $request->only('username_or_email', 'password');

        if (Auth::guard($clientType)->attempt($credentials)) {
            // Store active client type in session
            session(['active_client_guard' => $clientType]);

            // Redirect to the correct dashboard
            switch ($clientType) {
                case 'student':
                    return redirect()->route('client.dashboard.student');
                case 'faculty':
                    return redirect()->route('client.dashboard.faculty');
                case 'alumni':
                    return redirect()->route('client.dashboard.alumni');
                case 'others':
                    return redirect()->route('client.dashboard.others');
            }
        }

        // Login failed
        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

}
