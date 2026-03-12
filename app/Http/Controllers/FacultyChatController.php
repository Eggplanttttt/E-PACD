<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesChatAttachments;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacultyChatController extends Controller
{
    use HandlesChatAttachments;

    /**
     * Fetch all messages for the logged-in faculty
     */
    private const ADMIN_REPLY_DELAY = 20;

    public function getMessages()
    {
        $faculty = auth('faculty')->user();

        if (!$faculty) {
            return response()->json(['success' => false, 'error' => 'Faculty not logged in.'], 401);
        }

        $clientId = $faculty->id;
        $clientType = 'faculty';

        $facultyName = trim(implode(' ', array_filter([
            $faculty->first_name ?? '',
            $faculty->middle_initial ?? '',
            $faculty->last_name ?? '',
            $faculty->suffix ?? ''
        ])));

        $messages = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'asc')
            ->get();

        // --- Auto-send system message if 30 seconds passed since last faculty message without admin reply ---
        $lastFacultyMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', "faculty/{$facultyName}")
            ->latest()
            ->first();

        $lastAdminMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', 'Admin')
            ->latest()
            ->first();

        if ($lastFacultyMsg) {
            $timeSinceFacultyMsg = now()->diffInSeconds($lastFacultyMsg->created_at);
            $noAdminReply = !$lastAdminMsg || $lastAdminMsg->created_at < $lastFacultyMsg->created_at;

            if ($timeSinceFacultyMsg >= self::ADMIN_REPLY_DELAY && $noAdminReply) {
                // Prevent duplicate system messages
                $existingSystem = Message::where('client_type', $clientType)
                    ->where('client_id', $clientId)
                    ->where('sender', 'System')
                    ->where('created_at', '>=', $lastFacultyMsg->created_at)
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
     * Send a new message from faculty
     */
    public function sendMessage(Request $request)
    {
        $request->validate(array_merge([
            'message' => 'nullable|string|max:1000',
        ], $this->chatAttachmentRules()), $this->chatAttachmentMessages());

        $faculty = auth('faculty')->user();
        if (!$faculty) {
            return response()->json(['success' => false, 'error' => 'Faculty not logged in.'], 401);
        }

        $clientId = $faculty->id;
        $clientType = 'faculty';
        $facultyName = trim(implode(' ', array_filter([
            $faculty->first_name ?? '',
            $faculty->middle_initial ?? '',
            $faculty->last_name ?? '',
            $faculty->suffix ?? ''
        ])));

        $rawMessage = trim($request->input('message'));
        $fromFaq = $request->input('from_faq', 0);
        $attachmentData = $this->storeChatAttachment($request);

        if ($rawMessage === '' && empty($attachmentData)) {
            return response()->json(['success' => false, 'error' => 'Message is empty.'], 422);
        }

        $censoredMessage = $this->censorBadWords($rawMessage);

        // Save faculty message
        try {
            $facultyMsg = Message::create([
                'client_type' => $clientType,
                'client_id' => $clientId,
                'sender' => "faculty/{$facultyName}",
                'message' => $censoredMessage !== '' ? $censoredMessage : null,
                'is_read' => 1,
                'unread_for_admin' => 1
            ] + $attachmentData);
        } catch (\Exception $e) {
            Log::error('Message save failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'DB Insert Failed: '.$e->getMessage()], 500);
        }

        // Normalize message for FAQ matching
        $normalizedMessage = strtolower(trim(preg_replace('/[^\w\s]/', '', $rawMessage)));

        $autoResponses = [
            "what are your office hours" => "Our office hours are 8:00 AM to 5:00 PM, Monday to Friday.",
            "how do i access class lists" => "You may request class lists from the Registrar’s Office at the start of the semester or access them via the student portal (MIS).",
            "what should i do if i need to correct a grade already submitted" => "Submit a grade correction form with approval from the Dean and Registrar. Supporting documents may be required.",
            "how do i request a certificate of employment or service record" => "Submit a request to HR. Processing takes about 1–2 working days. MIS / IT Services.",
            "how do i access the faculty portal for encoding grades" => "Your accounts are created by MIS. If login issues occur, request assistance at the MIS Office.",
            "how do i request the use of a university vehicle" => "You can submit a Request for Vehicle Form in the General Service Unit at the 3rd floor in JAAH Building, with an approved travel order at least 3 days before the trip."
        ];

        // Send FAQ auto-response if applicable
        if (isset($autoResponses[$normalizedMessage])) {
            Message::create([
                'client_type' => $clientType,
                'client_id' => $clientId,
                'sender' => 'System',
                'message' => $autoResponses[$normalizedMessage],
                'is_read' => 0,
                'unread_for_admin' => 0
            ]);
        }

        return response()->json(['success' => true, 'message' => $facultyMsg]);
    }

    /**
     * Helper: Censor bad words
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
            $replacement = str_repeat('*', strlen($word));
            $text = preg_replace($pattern, $replacement, $text);
        }

        return $text;
    }
}
