<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SendAutoReplies extends Command
{
    protected $signature = 'messages:send-auto-reply';
    protected $description = 'Send system auto-reply if admin is offline';

    public function handle()
    {
        $now = Carbon::now();
        $threshold = $now->subMinute(); // messages older than 1 min

        // Get faculty messages without admin reply
        $messages = Message::where('client_type', 'faculty')
            ->where('sender', 'like', 'faculty/%')
            ->where('created_at', '<=', $threshold)
            ->whereDoesntHave('replies', function ($q) {
                $q->where('sender', 'Admin');
            })
            ->get();

        foreach ($messages as $msg) {
            // Check if admin is online
            $adminOnline = DB::table('admin_account')
                ->where('last_active_at', '>=', Carbon::now()->subMinute())
                ->exists();

            if (!$adminOnline) {
                Message::create([
                    'client_type' => $msg->client_type,
                    'client_id' => $msg->client_id,
                    'sender' => 'System',
                    'message' => 'Thank you for your message. We will get back to you shortly.',
                    'is_read' => 0,
                    'unread_for_admin' => 0
                ]);
            }
        }
    }
}
?>