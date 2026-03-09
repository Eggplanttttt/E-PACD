<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Alumni;
use App\Models\Other;
use Illuminate\Support\Facades\Log;

class AdminInquiryController extends Controller
{
    /**
     * Display all clients with messages.
     */
    public function index()
    {
        $clientsFromMessages = Message::select('client_type', 'client_id', DB::raw('MAX(created_at) as last_message_at'))
            ->where(function($q) {
                $q->where('solved', '!=', 1)
                  ->orWhereNull('solved');
            })
            ->groupBy('client_type', 'client_id')
            ->orderByDesc('last_message_at')
            ->get();

        $clients = $clientsFromMessages->map(function ($item) {
            $client = null;
            switch (strtolower($item->client_type)) {
                case 'student':
                    $client = Student::find($item->client_id);
                    break;
                case 'faculty':
                    $client = Faculty::find($item->client_id);
                    break;
                case 'alumni':
                    $client = Alumni::find($item->client_id);
                    break;
                case 'others':
                    $client = Other::find($item->client_id);
                    break;
            }

            $display_name = $client
                ? trim(
                    ($client->first_name ?? '') . ' ' .
                    ($client->middle_initial ? $client->middle_initial . ' ' : '') .
                    ($client->last_name ?? '') .
                    ($client->suffix ? ' ' . $client->suffix : '')
                ) 
                : ucfirst($item->client_type) . ' #' . $item->client_id;

            if (!$display_name && $client) {
                $display_name = $client->fullname ?? $client->name ?? $client->email ?? ucfirst($item->client_type) . ' #' . $item->client_id;
            }

            $total_unread = Message::where('client_id', $item->client_id)
                ->whereRaw('LOWER(client_type) = ?', [strtolower($item->client_type)])
                ->where('sender', '!=', 'admin')
                ->where('sender', '!=', 'system')
                ->where('unread_for_admin', true)
                ->where(function($q) {
                    $q->where('solved', '!=', 1)
                      ->orWhereNull('solved');
                })
                ->count();

            $total_messages = Message::where('client_id', $item->client_id)
                ->whereRaw('LOWER(client_type) = ?', [strtolower($item->client_type)])
                ->count();

            return (object)[
                'client_id'      => $item->client_id,
                'client_type'    => strtolower($item->client_type),
                'display_name'   => $display_name,
                'total_unread'   => $total_unread,
                'total_messages' => $total_messages,
                'last_message_at'=> $item->last_message_at,
            ];
        });

        return view('admin.admin-inquiries', compact('clients'));
    }

    public function ioIndex()
    {
        $clientsFromMessages = Message::select('client_type', 'client_id', DB::raw('MAX(created_at) as last_message_at'))
            ->where(function($q) {
                $q->where('solved', '!=', 1)
                ->orWhereNull('solved');
            })
            ->groupBy('client_type', 'client_id')
            ->orderByDesc('last_message_at')
            ->get();

        $clients = $clientsFromMessages->map(function ($item) {
            $client = null;

            switch (strtolower($item->client_type)) {
                case 'student':
                    $client = Student::find($item->client_id);
                    break;
                case 'faculty':
                    $client = Faculty::find($item->client_id);
                    break;
                case 'alumni':
                    $client = Alumni::find($item->client_id);
                    break;
                case 'others':
                    $client = Other::find($item->client_id);
                    break;
            }

            $display_name = $client
                ? trim(
                    ($client->first_name ?? '') . ' ' .
                    ($client->middle_initial ? $client->middle_initial . ' ' : '') .
                    ($client->last_name ?? '') .
                    ($client->suffix ? ' ' . $client->suffix : '')
                )
                : ucfirst($item->client_type) . ' #' . $item->client_id;

            if (!$display_name && $client) {
                $display_name = $client->fullname ?? $client->name ?? $client->email ?? ucfirst($item->client_type) . ' #' . $item->client_id;
            }

            $total_unread = Message::where('client_id', $item->client_id)
                ->whereRaw('LOWER(client_type) = ?', [strtolower($item->client_type)])
                ->where('sender', '!=', 'admin')
                ->where('sender', '!=', 'system')
                ->where('unread_for_admin', true)
                ->where(function($q) {
                    $q->where('solved', '!=', 1)
                    ->orWhereNull('solved');
                })
                ->count();

            $total_messages = Message::where('client_id', $item->client_id)
                ->whereRaw('LOWER(client_type) = ?', [strtolower($item->client_type)])
                ->count();

            return (object)[
                'client_id'       => $item->client_id,
                'client_type'     => strtolower($item->client_type),
                'display_name'    => $display_name,
                'total_unread'    => $total_unread,
                'total_messages'  => $total_messages,
                'last_message_at' => $item->last_message_at,
            ];
        });

        return view('io.inquiries', compact('clients'));
    }

    public function markAsRead($clientType, $clientId)
    {
        $map = [
            'students'  => 'student',
            'faculties' => 'faculty',
            'alumnis'   => 'alumni',
            'others'    => 'others',
        ];

        $clientTypeSingular = strtolower($map[$clientType] ?? $clientType);

        Message::where('client_id', $clientId)
            ->whereRaw('LOWER(client_type) = ?', [$clientTypeSingular])
            ->where('sender', '!=', 'admin')
            ->where('sender', '!=', 'system')
            ->where('unread_for_admin', true)
            ->update(['unread_for_admin' => false]);

        return response()->json(['success' => true]);
    }

    /**
     * Fetch messages for a specific client
     */
    public function getMessages($clientType, $clientId)
    {
        $map = [
            'students'  => 'student',
            'faculties' => 'faculty',
            'alumnis'   => 'alumni',
            'others'    => 'others',
        ];

        $clientTypeSingular = strtolower($map[$clientType] ?? $clientType);

        $messages = Message::where('client_id', $clientId)
            ->whereRaw('LOWER(client_type) = ?', [$clientTypeSingular])
            ->orderBy('created_at', 'asc')
            ->get();

        $messages = $messages->map(function ($msg) {
            $senderName = match($msg->sender) {
                'admin'  => 'Admin',
                'system' => 'System',
                default  => str_contains($msg->sender, '/') ? explode('/', $msg->sender, 2)[1] : $msg->sender,
            };

            return [
                'id'          => $msg->id,
                'client_id'   => $msg->client_id,
                'client_type' => strtolower($msg->client_type),
                'sender'      => $msg->sender,
                'sender_name' => trim($senderName),
                'message'     => $msg->message,
                'created_at'  => $msg->created_at->toDateTimeString(),
                'unread_for_admin' => $msg->unread_for_admin,
            ];
        });

        // Mark as read for admin (only client messages)
        Message::where('client_id', $clientId)
            ->whereRaw('LOWER(client_type) = ?', [$clientTypeSingular])
            ->where('sender', '!=', 'admin')
            ->where('sender', '!=', 'system')
            ->where('unread_for_admin', true)
            ->update(['unread_for_admin' => false]);

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Send a message from Admin
     */
    public function send(Request $request)
    {
        $request->validate([
            'client_id'   => 'required|string',
            'client_type' => 'required|string',
            'sender'      => 'required|string',
            'message'     => 'required|string|max:5000',
        ]);

        $sender = strtolower($request->sender);

        try {
            $msg = Message::create([
                'client_id'        => $request->client_id,
                'client_type'      => strtolower($request->client_type),
                'sender'           => $sender,
                'message'          => $request->message,
                'unread_for_admin' => $sender !== 'admin' ? 1 : 0,
                'is_read'          => $sender === 'admin' ? 0 : 1,
            ]);
        } catch (\Exception $e) {
            Log::error('Admin send message failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Message send failed.']);
        }

        return response()->json([
            'success' => true,
            'message' => [
                'id'          => $msg->id,
                'client_id'   => $msg->client_id,
                'client_type' => $msg->client_type,
                'sender'      => $msg->sender,
                'sender_name' => $msg->sender === 'admin' ? 'Admin' : 'Client',
                'message'     => $msg->message,
                'created_at'  => $msg->created_at->toDateTimeString(),
                'unread_for_admin' => $msg->unread_for_admin,
            ]
        ]);
    }

    /**
     * Mark inquiry as solved
     */
    public function markSolved(Request $request)
    {
        $request->validate([
            'client_id'   => 'required',
            'client_type' => 'required',
        ]);

        $clientId = $request->client_id;
        $clientType = strtolower($request->client_type);

        $messageText = "Your inquiry is marked as solved. You can chat again if needed. 
                        Feedback: <a href='" . route('feedback.form') . "' target='_blank'>Form</a>";

        Message::create([
            'client_id' => $clientId,
            'client_type' => $clientType,
            'sender' => 'system',
            'message' => $messageText,
            'unread_for_admin' => false,
            'solved' => 1
        ]);

        Message::where('client_id', $clientId)
            ->where('client_type', $clientType)
            ->where('sender', '!=', 'admin')
            ->update(['unread_for_admin' => false]);

        return response()->json(['success' => true]);
    }

    /**
     * Get unread counts for admin dashboard
     */
    public function unreadCounts()
    {
        $unreadCounts = Message::where('unread_for_admin', 1)
            ->where('sender', '!=', 'admin')
            ->where('sender', '!=', 'system')
            ->where(function($q) {
                $q->where('solved', '!=', 1)
                  ->orWhereNull('solved');
            })
            ->select('client_type', 'client_id', DB::raw('COUNT(*) as unread'))
            ->groupBy('client_type', 'client_id')
            ->get();

        $counts = [];
        foreach ($unreadCounts as $row) {
            $key = strtolower($row->client_type) . '-' . $row->client_id;
            $counts[$key] = $row->unread;
        }

        $latestMessage = Message::latest()->first();
        $latestClient = $latestMessage ? [
            'client_id' => $latestMessage->client_id,
            'client_type' => strtolower($latestMessage->client_type),
        ] : null;

        return response()->json([
            'success' => true,
            'unreadCounts' => $counts,
            'latestMessageClient' => $latestClient,
        ]);
    }

    /**
 * Return REAL-TIME updated client list
 */
public function fetchClients()
{
    // Get all clients that still have active conversations (not solved)
    $clientsFromMessages = Message::select(
            'client_type',
            'client_id',
            DB::raw('MAX(created_at) as last_message_at')
        )
        ->where(function ($q) {
            $q->where('solved', '!=', 1)
              ->orWhereNull('solved');
        })
        ->groupBy('client_type', 'client_id')
        ->orderByDesc('last_message_at')
        ->get();

    // Convert each client to an object for frontend
    $clients = $clientsFromMessages->map(function ($item) {

        // Fetch client record
        $client = match (strtolower($item->client_type)) {
            'student' => Student::find($item->client_id),
            'faculty' => Faculty::find($item->client_id),
            'alumni'  => Alumni::find($item->client_id),
            'others'  => Other::find($item->client_id),
            default   => null
        };

        // Build proper display name
        $displayName = $client
            ? trim(
                ($client->first_name ?? '') . ' ' .
                ($client->middle_initial ? $client->middle_initial . ' ' : '') .
                ($client->last_name ?? '') .
                ($client->suffix ? ' ' . $client->suffix : '')
            )
            : ucfirst($item->client_type) . ' #' . $item->client_id;

        // Count unread for admin
        $unread = Message::where('client_id', $item->client_id)
            ->whereRaw('LOWER(client_type) = ?', [strtolower($item->client_type)])
            ->where('sender', '!=', 'admin')
            ->where('sender', '!=', 'system')
            ->where('unread_for_admin', true)
            ->where(function ($q) {
                $q->where('solved', '!=', 1)
                  ->orWhereNull('solved');
            })
            ->count();

        return [
            'client_id'    => $item->client_id,
            'client_type'  => strtolower($item->client_type),
            'display_name' => $displayName,
            'unread'       => $unread,
            'last_message_at' => $item->last_message_at,
        ];
    });

    return response()->json([
        'success' => true,
        'clients' => $clients
    ]);
}

}
