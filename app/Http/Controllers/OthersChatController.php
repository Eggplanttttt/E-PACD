<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OthersChatController extends Controller
{
    private const ADMIN_REPLY_DELAY = 10;
    private const NAV_PENDING_DESTINATION_KEY = 'others_nav_pending_destination';
    
    public function __construct()
    {
        $this->middleware('auth:others');

        // Prevent back button after logout
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        });
    }

    /**
     * Fetch all messages for the logged-in visitor/other
     */
    public function getMessages()
    {
        $others = auth('others')->user();
        if (!$others) {
            return response()->json(['success' => false, 'error' => 'Visitor not logged in.'], 401);
        }

        $clientId = $others->id;
        $clientType = 'others';
        $name = trim(implode(' ', array_filter([
            $others->first_name ?? '',
            $others->middle_initial ?? '',
            $others->last_name ?? '',
            $others->suffix ?? ''
        ])));

        $messages = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Auto-send system message if 30 seconds passed since last visitor message without admin reply
        $lastVisitorMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', "others/{$name}")
            ->latest()
            ->first();

        $lastAdminMsg = Message::where('client_type', $clientType)
            ->where('client_id', $clientId)
            ->where('sender', 'Admin')
            ->latest()
            ->first();

        if ($lastVisitorMsg) {
            $timeSinceVisitorMsg = now()->diffInSeconds($lastVisitorMsg->created_at);
            $noAdminReply = !$lastAdminMsg || $lastAdminMsg->created_at < $lastVisitorMsg->created_at;

            if ($timeSinceVisitorMsg >= self::ADMIN_REPLY_DELAY && $noAdminReply) {
                $existingSystem = Message::where('client_type', $clientType)
                    ->where('client_id', $clientId)
                    ->where('sender', 'System')
                    ->where('created_at', '>=', $lastVisitorMsg->created_at)
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
     * Send a new message from visitor/other
     */
    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $others = auth('others')->user();
        if (!$others) {
            return response()->json(['success' => false, 'error' => 'Visitor not logged in.'], 401);
        }

        $clientId = $others->id;
        $clientType = 'others';
        $name = trim(implode(' ', array_filter([
            $others->first_name ?? '',
            $others->middle_initial ?? '',
            $others->last_name ?? '',
            $others->suffix ?? ''
        ])));

        $rawMessage = trim($request->message);
        $fromFaq = $request->input('from_faq', 0);

        if (empty($rawMessage)) {
            return response()->json(['success' => false, 'error' => 'Message is empty.'], 422);
        }

        $censoredMessage = $this->censorBadWords($rawMessage);

        try {
            $visitorMsg = Message::create([
                'client_type' => $clientType,
                'client_id' => $clientId,
                'sender' => "others/{$name}",
                'message' => $censoredMessage,
                'is_read' => 1,
                'unread_for_admin' => 1
            ]);
        } catch (\Exception $e) {
            Log::error('Message save failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'DB Insert Failed: '.$e->getMessage()], 500);
        }

        if (!$fromFaq) {
            $navigationReply = $this->handleCampusNavigationFlow($request, $others, $rawMessage, $clientType, $clientId);
            if ($navigationReply !== null) {
                return response()->json([
                    'success' => true,
                    'message' => $visitorMsg,
                    'system_message' => $navigationReply
                ]);
            }
        }

        // FAQ Auto-Response
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
                'message' => $visitorMsg,
                'system_message' => $systemMsg
            ]);
        }

        // Admin auto-reply if not FAQ
        if (!$fromFaq) {
            $lastVisitorMsg = Message::where('client_type', $clientType)
                ->where('client_id', $clientId)
                ->where('sender', "others/{$name}")
                ->latest()
                ->first();

            $lastAdminMsg = Message::where('client_type', $clientType)
                ->where('client_id', $clientId)
                ->where('sender', 'Admin')
                ->latest()
                ->first();

            $noAdminReplyAfterVisitor = !$lastAdminMsg || $lastAdminMsg->created_at < $lastVisitorMsg->created_at;
            $timeSinceVisitor = $lastVisitorMsg ? now()->diffInSeconds($lastVisitorMsg->created_at) : 0;

            if ($lastVisitorMsg && $timeSinceVisitor >= self::ADMIN_REPLY_DELAY && $noAdminReplyAfterVisitor) {
                $existingSystem = Message::where('client_type', $clientType)
                    ->where('client_id', $clientId)
                    ->where('sender', 'System')
                    ->where('created_at', '>=', $lastVisitorMsg->created_at)
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
                        'message' => $visitorMsg,
                        'system_message' => $systemMsg
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => $visitorMsg]);
    }

    private function normalizeFaqKeys(array $faq)
    {
        $normalized = [];
        foreach ($faq as $question => $answer) {
            $key = strtolower(preg_replace('/[^\w\s]/', '', $question));
            $normalized[$key] = $answer;
        }
        return $normalized;
    }

    private function autoResponses()
    {
        return [
            "What are your office hours?" => "Our office hours are 8:00 AM to 5:00 PM, Monday to Friday.",
            "Where is the registrar's office?" => "The registrar's office is located at the JAAH building, 2nd floor.",
            "How to request TOR?" => "You can request your TOR by visiting the registrar's office at the JAAH building, 2nd floor.",
            "Can I still enroll late?" => "Yes, late enrollment is allowed within the first week of classes with valid justification. Visit our <a href='https://www.facebook.com/QSUOfficial' target='_blank'>Facebook Page</a> for updates.",
            "What are the requirements for enrolling as a freshman or transferee?" => "DOCUMENTARY REQUIREMENTS: Certificate of Transfer Credentials, Certificate of Grades, Certificate of Good Moral Character, PSA Birth Certificate, PSA Marriage Certificate (if married). Bring originals and photocopies, 4 pcs 2x2 ID picture, long brown folder.",
            "What courses or degree programs are offered at this university?" => "COLLEGE OF TEACHER EDUCATION: BEE, BSE, BTLED. COLLEGE OF AGRICULTURE, FORESTRY & ENGINEERING: CAS-BSA, BSABE, BS Forestry. COLLEGE OF IT & COMPUTING SCIENCES: BSIT, BS OA. COLLEGE OF PUBLIC SAFETY: BS Criminology. COLLEGE OF HEALTH SCIENCES: BS Nutrition and Dietetics, Caregiving NC II. COLLEGE OF HOSPITALITY & INDUSTRY MANAGEMENT: BS Hospitality, BS Tourism.",
            "Do I need to take an entrance exam?" => "Yes, all incoming freshmen must take the QSU College Admission Test (QSU-CAT).",
            "How do I register for the entrance exam?" => "Fill out the Admission Test Application Form, submit your requirements, and wait for your schedule.",
            "Does the Guidance Office conduct orientations for new students?" => "Yes, freshmen orientation includes guidance services and university rules.",
            "How do I apply for a job at QSU?" => "Submit your application letter, PDS, TOR, eligibility/certifications, and supporting documents to the HR Office.",
            "Where are job vacancies posted?" => "Vacancies are posted on the <a href='https://www.facebook.com/qsuhrmo' target='_blank'>QSU HRMO</a> Facebook page.",
            "What is the recruitment process?" => "Screening → Exam → Interview → HRMPSB Deliberation → President Approval."
        ];
    }

    private function handleCampusNavigationFlow(Request $request, $others, string $rawMessage, string $clientType, int $clientId): ?Message
    {
        $message = $this->normalizeText($rawMessage);
        $pendingKey = $this->navigationSessionKey($others->id);
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

    private function navigationSessionKey(int $othersId): string
    {
        return self::NAV_PENDING_DESTINATION_KEY.'_'.$othersId;
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
