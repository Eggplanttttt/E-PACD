<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Models\Message;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Auto-reply system messages to clients if no admin response
        $schedule->call(function () {
            // For testing, you can set 1 minute; in production, change to subHours(24)
            $threshold = now()->subMinutes(1);

            $conversations = Message::select('client_type', 'client_id')
                ->where(function ($q) {
                    $q->where('solved', '!=', 1)->orWhereNull('solved');
                })
                ->groupBy('client_type', 'client_id')
                ->get()
                ->filter(function ($conv) use ($threshold) {
                    $latestClientMsg = Message::where('client_type', $conv->client_type)
                        ->where('client_id', $conv->client_id)
                        ->where('sender', '!=', 'admin')
                        ->latest()
                        ->first();

                    return !$latestClientMsg || $latestClientMsg->created_at < $threshold;
                });

            foreach ($conversations as $conv) {
                // Check if a system message already exists to prevent duplicates
                $exists = Message::where('client_type', $conv->client_type)
                    ->where('client_id', $conv->client_id)
                    ->where('sender', 'system')
                    ->where('created_at', '>=', $threshold)
                    ->exists();

                if (!$exists) {
                    Message::create([
                        'client_id' => $conv->client_id,
                        'client_type' => $conv->client_type,
                        'sender' => 'system',
                        'message' => "Thank you for your message. We will get back to you shortly.",
                        'solved' => 0, // mark as not solved yet
                        'is_read' => false,
                        'unread_for_admin' => false,
                    ]);
                }
            }
        })->everyMinute(); // change to hourly() or daily() for production

        // If you have a custom artisan command, schedule it here
        // $schedule->command('messages:send-auto-reply')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
