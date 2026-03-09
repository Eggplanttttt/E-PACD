<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Show messages for the logged-in student
    public function index()
    {
        $client = Auth::guard('student')->user();

        $messages = Message::where('client_id', $client->id)
            ->where('client_type', 'student')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('student.dashboard', compact('messages'));
    }

    // Store new message
    public function store(Request $request)
    {
        $client = Auth::guard('student')->user();

        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Client not authenticated']);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'client_id'   => $client->id,
            'client_type' => 'student',
            'message'     => $request->message,
            'sender'      => 'client',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully'
        ]);
    }
}
