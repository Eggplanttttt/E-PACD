<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesChatAttachments;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AlumniChatController extends Controller
{
    use HandlesChatAttachments;

    private const ADMIN_REPLY_DELAY = 20; 

    public function __construct()
    {
        $this->middleware('auth:alumni');

        // Prevent back button after logout
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        });
    }

    /**
     * Fetch all messages for the logged-in alumni
     */
    public function getMessages()
    {
        $alumni = auth('alumni')->user();
        if (!$alumni) {
            return response()->json(['success' => false, 'error' => 'Alumni not logged in.'], 401);
        }

        $clientId = $alumni->id;
        $clientType = 'alumni';
        $alumniName = trim(implode(' ', array_filter([
            $alumni->first_name ?? '',
            $alumni->middle_name ?? '',
            $alumni->last_name ?? '',
            $alumni->suffix ?? ''
        ])));

        $messages = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'asc')
            ->get();

        // --- Auto-send system message if 30 seconds passed since last alumni message without admin reply ---
        $lastAlumniMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', "alumni/{$alumniName}")
            ->latest()
            ->first();

        $lastAdminMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', 'Admin')
            ->latest()
            ->first();

        if ($lastAlumniMsg) {
            $timeSinceAlumniMsg = now()->diffInSeconds($lastAlumniMsg->created_at);
            $noAdminReply = !$lastAdminMsg || $lastAdminMsg->created_at < $lastAlumniMsg->created_at;

            if ($timeSinceAlumniMsg >= self::ADMIN_REPLY_DELAY && $noAdminReply) {
                $existingSystem = Message::where('client_type', $clientType)
                    ->where('client_id', $clientId)
                    ->where('sender', 'System')
                    ->where('created_at', '>=', $lastAlumniMsg->created_at)
                    ->exists();

                if (!$existingSystem) {
                    $systemMsg = Message::create([
                        'client_type' => $clientType,
                        'client_id' => $clientId,
                        'sender' => 'System',
                        'message' => 'Thank you for your message and sorry for the delay. You can leave your questions or you can check it later. Thank you!',
                        'is_read' => 0,
                        'unread_for_admin' => 0
                    ]);
                    $messages->push($systemMsg);
                }
            }
        }

        return response()->json(['success' => true, 'messages' => $messages]);
    }

    /**
     * Send a new message from alumni
     */
    public function sendMessage(Request $request)
    {
        $request->validate(array_merge([
            'message' => 'nullable|string|max:1000',
        ], $this->chatAttachmentRules()), $this->chatAttachmentMessages());

        $alumni = auth('alumni')->user();
        if (!$alumni) {
            return response()->json(['success' => false, 'error' => 'Alumni not logged in.'], 401);
        }

        $clientId = $alumni->id;
        $clientType = 'alumni';
        $alumniName = trim(implode(' ', array_filter([
            $alumni->first_name ?? '',
            $alumni->middle_name ?? '',
            $alumni->last_name ?? '',
            $alumni->suffix ?? ''
        ])));

        $rawMessage = trim($request->input('message'));
        $fromFaq = $request->input('from_faq', 0);
        $attachmentData = $this->storeChatAttachment($request);

        if ($rawMessage === '' && empty($attachmentData)) {
            return response()->json(['success' => false, 'error' => 'Message is empty.'], 422);
        }

        $censoredMessage = $this->censorBadWords($rawMessage);

        try {
            $alumniMsg = Message::create([
                'client_type' => $clientType,
                'client_id' => $clientId,
                'sender' => "alumni/{$alumniName}",
                'message' => $censoredMessage !== '' ? $censoredMessage : null,
                'is_read' => 1,
                'unread_for_admin' => 1
            ] + $attachmentData);
        } catch (\Exception $e) {
            Log::error('Message save failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'DB Insert Failed: '.$e->getMessage()], 500);
        }

        // --- FAQ Auto-Response ---
        $autoResponses = $this->normalizeFaqKeys($this->autoResponses());
        $normalizedMessage = strtolower(trim(preg_replace('/[^\w\s]/', '', $rawMessage)));

        if (isset($autoResponses[$normalizedMessage])) {
            $systemMsg = Message::create([
                'client_type' => $clientType,
                'client_id' => $clientId,
                'sender' => 'System',
                'message' => $autoResponses[$normalizedMessage],
                'is_read' => 0,
                'unread_for_admin' => 0
            ]);

            return response()->json([
                'success' => true,
                'message' => $alumniMsg,
                'system_message' => $systemMsg
            ]);
        }

        // --- System auto-reply if admin hasn't responded in 30s ---
        if (!$fromFaq) {
            $lastAlumniMsg = Message::where('client_type', $clientType)
                ->where('client_id', $clientId)
                ->where('sender', "alumni/{$alumniName}")
                ->latest()
                ->first();

            $lastAdminMsg = Message::where('client_type', $clientType)
                ->where('client_id', $clientId)
                ->where('sender', 'Admin')
                ->latest()
                ->first();

            $noAdminReplyAfterAlumni = !$lastAdminMsg || $lastAdminMsg->created_at < $lastAlumniMsg->created_at;
            $timeSinceAlumni = $lastAlumniMsg ? now()->diffInSeconds($lastAlumniMsg->created_at) : 0;

            if ($lastAlumniMsg && $timeSinceAlumni >= self::ADMIN_REPLY_DELAY && $noAdminReplyAfterAlumni) {

                $existingSystem = Message::where('client_type', $clientType)
                    ->where('client_id', $clientId)
                    ->where('sender', 'System')
                    ->where('created_at', '>=', $lastAlumniMsg->created_at)
                    ->exists();

                if (!$existingSystem) {
                    $systemMsg = Message::create([
                        'client_type' => $clientType,
                        'client_id' => $clientId,
                        'sender' => 'System',
                        'message' => 'Thank you for your message and sorry for the delay. You can leave your questions or you can check it later. Thank you!',
                        'is_read' => 0,
                        'unread_for_admin' => 0
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => $alumniMsg,
                        'system_message' => $systemMsg
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => $alumniMsg]);
    }

    /**
     * Normalize FAQ keys for matching
     */
    private function normalizeFaqKeys(array $faq)
    {
        $normalized = [];
        foreach ($faq as $question => $answer) {
            $key = strtolower(preg_replace('/[^\w\s]/', '', $question));
            $normalized[$key] = $answer;
        }
        return $normalized;
    }

    /**
     * Auto response list
     */
    private function autoResponses()
    {
        return [
            "What are your office hours?" => "Our office hours are 8:00 AM to 5:00 PM, Monday to Friday.",
            "How do I get my alumni clearance signed after graduation?" => "Provide your clearance slip from the Cashier, verify your name in the graduation list, and attend alumni orientation.",
            "Can someone else process my clearance on my behalf?" => "Yes, with an authorization letter and photocopies of IDs.",
            "How do I update my alumni records after graduation?" => "Fill out the Alumni Information Form at the Alumni Office.",
            "Is alumni data updating required?" => "Yes, to help the university track graduate employment and career paths.",
            "What are the benefits of being part of the Alumni Association?" => "Access to alumni programs, events, networking, and job assistance.",
            "How do alumni get involved in university projects?" => "Volunteer, donate, or participate in programs coordinated by the Alumni Office.",
            "Does the Alumni Office conduct alumni homecoming events?" => "Yes, the office organizes alumni homecomings and related activities."
        ];
    }

    /**
     * Censor bad words
     */
    private function censorBadWords($text)
    {
        $badWords = [
            'gago','putangina','putang-ina','putang-inamo','putanginamo',
            'ulol','tangina','bwisit','leche','pakshet','punyeta','tarantado',
            'bobo','tanga','gunggong','gaga','lintik','siraulo','wala kang kwenta','inutil',
            'fuck','motherfucker','asshole','ass','shit','bullshit','fuckshit',
            'bastard','bitch','dick','pussy','slut','whore','hoe','cunt',
            'dumbass','stupid','idiot','jerk','moron','loser',
            'nigga','nigger','chink','spic','faggot','gaylord'
        ];

        foreach ($badWords as $word) {
            $pattern = "/\b" . preg_quote($word, '/') . "\b/i";
            $text = preg_replace($pattern, str_repeat('*', strlen($word)), $text);
        }

        return $text;
    }
}
