<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentChatController extends Controller
{
    private const ADMIN_REPLY_DELAY = 10;
    private const NAV_PENDING_DESTINATION_KEY = 'student_nav_pending_destination';

    public function __construct()
    {
        $this->middleware('auth:student');

        // Prevent back button after logout
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        });
    }

    /**
     * Fetch all messages for the logged-in student
     */
    public function getMessages()
    {
        $student = auth('student')->user();
        if (!$student) {
            return response()->json(['success' => false, 'error' => 'Student not logged in.'], 401);
        }

        $clientId = $student->id;
        $clientType = 'student';
        $studentName = trim(implode(' ', array_filter([
            $student->first_name ?? '',
            $student->middle_initial ?? '',
            $student->last_name ?? '',
            $student->suffix ?? ''
        ])));

        $messages = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'asc')
            ->get();

        // --- Auto-send system message if 30 seconds passed since last student message without admin reply ---
        $lastStudentMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', "student/{$studentName}")
            ->latest()
            ->first();

        $lastAdminMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', 'Admin')
            ->latest()
            ->first();

        if ($lastStudentMsg) {
            $timeSinceStudentMsg = now()->diffInSeconds($lastStudentMsg->created_at);
            $noAdminReply = !$lastAdminMsg || $lastAdminMsg->created_at < $lastStudentMsg->created_at;

            if ($timeSinceStudentMsg >= self::ADMIN_REPLY_DELAY && $noAdminReply) {
                $existingSystem = Message::where('client_type', $clientType)
                    ->where('client_id', $clientId)
                    ->where('sender', 'System')
                    ->where('created_at', '>=', $lastStudentMsg->created_at)
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
     * Send a new message from student
     */
    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $student = auth('student')->user();
        if (!$student) {
            return response()->json(['success' => false, 'error' => 'Student not logged in.'], 401);
        }

        $clientId = $student->id;
        $clientType = 'student';
        $studentName = trim(implode(' ', array_filter([
            $student->first_name ?? '',
            $student->middle_initial ?? '',
            $student->last_name ?? '',
            $student->suffix ?? ''
        ])));

        $rawMessage = trim($request->input('message'));
        $fromFaq = $request->input('from_faq', 0);

        if (empty($rawMessage)) {
            return response()->json(['success' => false, 'error' => 'Message is empty.'], 422);
        }

        $censoredMessage = $this->censorBadWords($rawMessage);

        // Save student message
        try {
            $studentMsg = Message::create([
                'client_type' => $clientType,
                'client_id' => $clientId,
                'sender' => "student/{$studentName}",
                'message' => $censoredMessage,
                'is_read' => 1,
                'unread_for_admin' => 1
            ]);
        } catch (\Exception $e) {
            Log::error('Message save failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'DB Insert Failed: '.$e->getMessage()], 500);
        }

        if (!$fromFaq) {
            $navigationReply = $this->handleCampusNavigationFlow($request, $student, $rawMessage, $clientType, $clientId);
            if ($navigationReply !== null) {
                return response()->json([
                    'success' => true,
                    'message' => $studentMsg,
                    'system_message' => $navigationReply
                ]);
            }
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
                'message' => $studentMsg,
                'system_message' => $systemMsg
            ]);
        }

        // --- System auto-reply if admin hasn't responded in 30s ---
        if (!$fromFaq) {
            $lastStudentMsg = Message::where('client_type', $clientType)
                ->where('client_id', $clientId)
                ->where('sender', "student/{$studentName}")
                ->latest()
                ->first();

            $lastAdminMsg = Message::where('client_type', $clientType)
                ->where('client_id', $clientId)
                ->where('sender', 'Admin')
                ->latest()
                ->first();

            $noAdminReplyAfterStudent = !$lastAdminMsg || $lastAdminMsg->created_at < $lastStudentMsg->created_at;
            $timeSinceStudent = $lastStudentMsg ? now()->diffInSeconds($lastStudentMsg->created_at) : 0;

            if ($lastStudentMsg && $timeSinceStudent >= self::ADMIN_REPLY_DELAY && $noAdminReplyAfterStudent) {
                $existingSystem = Message::where('client_type', $clientType)
                    ->where('client_id', $clientId)
                    ->where('sender', 'System')
                    ->where('created_at', '>=', $lastStudentMsg->created_at)
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
                        'message' => $studentMsg,
                        'system_message' => $systemMsg
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => $studentMsg]);
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
            "Where can I get a copy of my transcript of grades?" => "You can request and get a copy at the registrar's office located at the JAAH building, 2nd Floor.",
            "Where is the registrar's office?" => "The registrar's office is located at the JAAH building, 2nd floor.",
            "How to request TOR?" => "You can request your TOR by visiting the registrar's office and located at the JAAH building, 2nd floor.",
            "Can I still enroll late?" => "Yes, late enrollment is allowed within the first week of classes with valid justification. You can also visit our Facebook Page <a href='https://www.facebook.com/QSUOfficial' target='_blank'>Quirino State University</a> so that you are updated on the enrollment.",
            "What are the requirements for enrolling as a freshman or transferee?" => "Here’s the list of requirements you need as New Students & Transferees: </br>
            <b>DOCUMENTARY REQUIREMENTS</b> </br>
            • Certificate of Transfer Credentials</br> 
            • Certificate of Grades</br>
            • Certificate of Good Moral Character</br>
            • PSA Authenticated Birth Certificate</br>
            • PSA Authenticated Marriage Certificate <i>(If Married)</i></br>
            <b>REMINDERS! PLEASE BRING THE FOLLOWING</b></br>
            • Original and Photocopy of your Documentary Requirements</br>
            • 4 pcs 2x2 ID Picture <i>(Formal, White Background with Nametag)</i></br>
            • Long Brown Folder <i>(Ordinary)</i></br></br>",
            "What courses or degree programs are offered at this university?" => "Here’s the list of courses or programs offered at Quirino State University (Diffun Main Campus) </br>
            <b>COLLEGE OF TEACHER EDUCATION</b></br>
            • Bachelor in Elementary Education</br>
            • Bachelor in Secondary Education<i>(English, Mathematics, Filipino, Science)</i></br>
            • Bachelor of Technology and Livelihood Education <i>(Home Economics, Information & Communication Technology, Agri-fishery Arts)</i></br>
            <b>COLLEGE OF AGRICULTURE, FORESTRY AND ENGINEERING</b></br>
            • Certificate of Agiriculture Science - Bachelor of Science in Agriculture<i>(CAS - BSA)</i></br>
            • Bachelor of Science in Agricultyure and Bio-systems Engineering</br>
            • Bachelor of Science in Forestry</br>
            <b>COLLEGE OF INFORMATION TECHNOLOGY & COMPUTING SCIENCES</b></br>
            • Bachelor of Science in Information Technology</br>
            • Bachelor of Science in Office Administration</br>
            <b>COLLEGE OF PUBLIC SAFETY</b></br>
            • Bachelor of Science in Criminology</br>
            <b>COLLEGE OF HEALTH SCIENCES</b></br>
            • Bachelor of Science in Nutition and Dietetics</br>
            • Caregiving NC II</br>
            <b>COLLEGE OF HOSPITALITY AND INDUSTRY MANAGEMENT</b></br>
            • Bachelor of Science in Hospitality Management</br>
            • Bachelor of Science in Tourism Management",
            "How do I apply for shifting to another course?" => "You need to secure a shifting form from the Registrar’s Office, located at the JAAH building, 2nd floor. And get approval from both the current and target departments, and submit all required documents.",
            "How do I request documents like certification, grades, or evaluation?" => "Secure a Request for Document form that you can get in the Registrar's Office, pay the required fee at the Cashier, and submit the receipt to the Registrar.",
            "How long does it take to process documents?" => "Most certifications or documents take 5 minutes to 1 day. However, TOR processing takes 15 working days.",
            "How do I withdraw my enrollment?" => "Get a form in Registrar's Office and fill out the Withdrawal Form, after that there is a required fee at the Cashier ₱20, and submit clearance, assessment, and class cards in the Registrar. The Registrar will cancel your subjects in the system.",
            "Can students avail of free medical consultation at QSU?" => "Yes. The Medical Services Office provides free consultation and treatment for minor illnesses and injuries to all students. And also you can follow and visit the <a href='https://www.facebook.com/qsudiffunhealthservices' target='_blank'>QSU Diffun Health Services</a> in Facebook for you to be updated."
        ];
    }

    private function handleCampusNavigationFlow(Request $request, $student, string $rawMessage, string $clientType, int $clientId): ?Message
    {
        $message = $this->normalizeText($rawMessage);
        $pendingKey = $this->navigationSessionKey($student->id);
        $pendingDestination = $request->session()->get($pendingKey);

        if ($pendingDestination) {
            if ($this->containsAny($message, ['cancel', 'stop', 'nevermind', 'never mind'])) {
                $request->session()->forget($pendingKey);
                return $this->createSystemMessage($clientType, $clientId, 'Navigation request cancelled. If you need directions, ask again anytime.');
            }

            if ($this->isOffCampusAnswer($message)) {
                return $this->createSystemMessage(
                    $clientType,
                    $clientId,
                    'If you are not in the campus yet, you can use Google Maps to find Quirino State University Diffun Main Campus. '
                    . 'Open this location: <a href="https://maps.google.com/?q=Quirino+State+University+Diffun+Main+Campus" target="_blank">Quirino State University Diffun Main Campus</a>. '
                    . 'For turn-by-turn directions from your current location, open: <a href="https://www.google.com/maps/dir/?api=1&destination=Quirino+State+University+Diffun+Main+Campus" target="_blank">Get Directions</a>.'
                );
            }

            // If user repeats destination question while we wait for current location,
            // keep state and ask for starting point again.
            $repeatedDestination = $this->matchDestination($message);
            if ($repeatedDestination === $pendingDestination && $this->isDirectionIntent($message)) {
                return $this->createSystemMessage(
                    $clientType,
                    $clientId,
                    sprintf(
                        'Sure, I can guide you to %s. Where are you right now? Example: "I am at the Main Gate."',
                        $this->destinationLabel($pendingDestination)
                    )
                );
            }

            $startPoint = $this->matchStartPoint($message);
            if ($startPoint) {
                $directions = $this->getDirections($pendingDestination, $startPoint);
                if ($directions) {
                    $request->session()->forget($pendingKey);
                    return $this->createSystemMessage($clientType, $clientId, $directions);
                }
            }

            $shortGateStartPoint = $this->matchShortGateAnswer($message);
            if ($shortGateStartPoint) {
                $directions = $this->getDirections($pendingDestination, $shortGateStartPoint);
                if ($directions) {
                    $request->session()->forget($pendingKey);
                    return $this->createSystemMessage($clientType, $clientId, $directions);
                }
            }

            if ($this->isGenericGateAnswer($message)) {
                return $this->createSystemMessage(
                    $clientType,
                    $clientId,
                    'I can guide you from the gate. Which gate are you at: Main Gate or Second Gate?'
                );
            }

            return $this->createSystemMessage(
                $clientType,
                $clientId,
                sprintf(
                    'Sure, I can guide you to %s. Where are you right now? Example: Main Gate, Second Gate/Back Gate, IT Building/BSIT Building, or BSOA Building.',
                    $this->destinationLabel($pendingDestination)
                )

            );
        }

        if (!$this->isDirectionIntent($message)) {
            return null;
        }

        $destination = $this->matchDestination($message);
        if (!$destination) {
            return null;
        }

        $request->session()->put($pendingKey, $destination);

        return $this->createSystemMessage(
            $clientType,
            $clientId,
            sprintf(
                'Sure, I can guide you to %s. Where are you right now? I will provide directions from your current location to %s.',
                $this->destinationLabel($destination),
                $this->destinationLabel($destination)
            )
        );
    }

    private function createSystemMessage(string $clientType, int $clientId, string $message): Message
    {
        return Message::create([
            'client_type' => $clientType,
            'client_id' => $clientId,
            'sender' => 'System',
            'message' => $message,
            'is_read' => 0,
            'unread_for_admin' => 0
        ]);
    }

    private function navigationSessionKey(int $studentId): string
    {
        return self::NAV_PENDING_DESTINATION_KEY.'_'.$studentId;
    }

    private function isDirectionIntent(string $message): bool
    {
        return $this->containsAny($message, [
            'where is',
            'where can i find',
            'location of',
            'located',
            'how do i go',
            'how to go',
            'how can i go',
            'help me go',
            'can you help me go',
            'can you help me get to',
            'please help me go',
            'please help me get to',
            'directions to',
            'how to get to',
            'how can i get to',
            'saan',
            'saan po',
            'saan yung',
            'saan ang',
            'nasaan',
            'nasan',
            'paano pumunta',
            'paano po pumunta',
            'papunta sa',
            'paano makarating',
            'paano po makarating',
            'san',
            'san po'
        ]);
    }

    private function matchDestination(string $message): ?string
    {
        foreach ($this->campusDestinations() as $destination => $aliases) {
            foreach ($aliases as $alias) {
                if (str_contains($message, $alias)) {
                    return $destination;
                }
            }
        }

        return null;
    }

    private function isGenericGateAnswer(string $message): bool
    {
        if (!str_contains($message, 'gate')) {
            return false;
        }

        // If a specific gate is already identified, this is not a generic gate answer.
        $mentionsMainGate = $this->containsAny($message, ['main gate', 'front gate', 'entrance gate']);
        $mentionsSecondGate = $this->containsAny($message, ['second gate', '2nd gate', 'back gate', 'rear gate', 'likod na gate', 'likod gate']);

        return !$mentionsMainGate && !$mentionsSecondGate;
    }

    private function isOffCampusAnswer(string $message): bool
    {
        if ($this->containsAny($message, [
            'not in school',
            'not at school',
            'not in campus',
            'outside campus',
            'outside the campus',
            'wala sa school',
            'wala ako sa school',
            'wala sa campus',
            'nasa labas',
            'hindi pa ako nasa school',
            'hindi pa ako nasa campus',
            'nasa bahay',
            'i am not in school',
            'im not in school',
            'i am outside campus',
            'im outside campus',
        ])) {
            return true;
        }

        // Common "I'm at home / house" style answers.
        if ($this->containsAny($message, [
            'at home',
            'at my home',
            'at house',
            'at my house',
            'in my house',
            'home in',
            'house in',
            'nasa bahay',
            'sa bahay',
        ])) {
            return true;
        }

        // City/province hints often mean user is outside campus context.
        if ($this->containsAny($message, [
            'cordon',
            'isabela',
            'santiago city',
            'cauayan',
            'diffun proper',
        ]) && !$this->matchStartPoint($message)) {
            return true;
        }

        return false;
    }

    private function matchShortGateAnswer(string $message): ?string
    {
        $hasMain = preg_match('/\bmain\b/', $message) === 1;
        $hasSecond = preg_match('/\b(second|2nd)\b/', $message) === 1;

        if ($hasMain && !$hasSecond) {
            return 'main_gate';
        }

        if ($hasSecond && !$hasMain) {
            return 'second_gate';
        }

        return null;
    }

    private function destinationLabel(string $destination): string
    {
        return match ($destination) {
            'jaah_building' => 'the JAAH Building',
            default => 'your destination',
        };
    }

    private function matchStartPoint(string $message): ?string
    {
        foreach ($this->campusStartPointAliases() as $startPoint => $aliases) {
            foreach ($aliases as $alias) {
                if (str_contains($message, $alias)) {
                    return $startPoint;
                }
            }
        }

        return null;
    }

    private function getDirections(string $destination, string $startPoint): ?string
    {
        $map = $this->campusDirectionsMap();

        return $map[$destination][$startPoint] ?? null;
    }

    private function campusDestinations(): array
    {
        return [
            'jaah_building' => [
                'jaah',
                'jaah building',
                'j a a h',
                'registrar office',
                'registrar',
                'registrar s office',
                'jaah bldg',
                'jaah na building'
            ],
        ];
    }

    private function campusStartPointAliases(): array
    {
        return [
            'main_gate' => ['main gate', 'maingate', 'front gate', 'entrance gate', 'nasa main gate', 'sa main gate'],
            'second_gate' => ['second gate', '2nd gate', 'likod na gate', 'likod gate', 'back gate', 'rear gate', 'nasa second gate', 'nasa likod na gate', 'sa likod na gate'],
            'it_building' => ['it building', 'bsit building', 'it', 'bsit', 'nasa it building', 'sa it building', 'nasa bsit building', 'sa bsit building'],
            'bsoa_building' => ['bsoa building', 'bsoa', 'nasa bsoa', 'sa bsoa', 'nasa bsoa building', 'sa bsoa building'],
        ];
    }

    private function campusDirectionsMap(): array
    {
        return [
            'jaah_building' => [
                'main_gate' => 'If you are at the Main Gate or Front Gate, go straight inside. You will see a straight path toward the BSED Building and another path to the right. Turn right and continue. When you see the BEED Building, pass it. Then take the uphill path on the right, and you will reach the JAAH Building.',
                'second_gate' => 'If you are at the Second Gate or Back Gate, go straight ahead. When you see the fishpond, turn right, then turn left going uphill. You will reach the JAAH Building.',
                'it_building' => 'If you are at the IT Building/BSIT Building, go up to the next building, and that is the JAAH Building.',
                'bsoa_building' => 'If you are at the BSOA Building, there are two routes. First route: go outside the BSOA Building, turn left facing the way to the Second Gate, then turn left again at the diversion. After going up, take another uphill turn to the left, and you will reach the JAAH Building. Second route: you can pass through the back of the BSOA Building, follow the uphill path, and you will reach the JAAH Building.',
            ],
        ];
    }

    private function normalizeText(string $text): string
    {
        $normalized = strtolower($text);
        $normalized = preg_replace('/[^\pL\pN\s]/u', ' ', $normalized);
        $normalized = preg_replace('/\s+/', ' ', trim($normalized));

        return $normalized;
    }

    private function containsAny(string $text, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_contains($text, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Censor bad words
     */
    private function censorBadWords($text)
    {
        $badWords = ['gago','putangina','ulol','tangina','bwisit','leche','tarantado','bobo','tanga','fuck','shit','bitch','asshole','cunt','pussy','slut','whore','dick','idiot','nigga','nigger','faggot'];
        foreach ($badWords as $word) {
            $pattern = "/\b".preg_quote($word,'/')."\b/i";
            $text = preg_replace($pattern, str_repeat('*', strlen($word)), $text);
        }
        return $text;
    }

    /**
     * Mark messages as read by admin
     */
    public function markAsReadByAdmin($clientId)
    {
        Message::where('client_id', $clientId)
            ->where('unread_for_admin', 1)
            ->update(['unread_for_admin' => 0]);

        return response()->json(['success' => true]);
    }

    /**
     * Logout student
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}











