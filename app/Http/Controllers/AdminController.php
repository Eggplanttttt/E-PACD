<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\AdminAccount;
use App\Models\Complaint;
use App\Models\ComplaintSolved;
use App\Models\RejectedComplaint;
use App\Models\Message;
use App\Models\Feedback; 
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Alumni;
use App\Models\Other;
use App\Models\Notification;
use App\Models\Review;
use Carbon\Carbon;
use App\Models\ClientBan;
use App\Models\ChatRating;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth'); // ensure the user is logged in

    //     // Prevent back button caching
    //     $this->middleware(function ($request, $next) {
    //         $response = $next($request);
    //         return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
    //                         ->header('Pragma', 'no-cache')
    //                         ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    //     });
    // }
    

    // Show Login Form
    public function showLoginForm()
    {
        return view('landing-page');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:super_admin,io,audit'],
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role, // ✅ IMPORTANT
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ redirect based on role
            $role = Auth::guard('admin')->user()->role;

            return match ($role) {
                'super_admin' => redirect()->route('admin.dashboard')->with('message', 'Welcome back!'),
                'io'          => redirect()->route('io.dashboard')->with('message', 'Welcome back!'),
                'audit'       => redirect()->route('audit.dashboard')->with('message', 'Welcome back!'),
                default       => redirect()->route('admin.login')->with('login_failed', true),
            };
        }

        return back()->with('login_failed', true)->withInput();
    }


    // Logout Admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home'); // or login page
    }

    // Dashboard
    public function dashboard(Request $request)
    {
        // Top 10 Departments (combined from 3 tables)
        $departmentRankings = DB::table(DB::raw("
            (
                SELECT department FROM complaints
                UNION ALL
                SELECT department FROM complaint_solved
            ) AS all_departments
        "))
        ->select('department', DB::raw('COUNT(*) as total'))
        ->groupBy('department')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

        $deptLabels = $departmentRankings->pluck('department');
        $deptCounts = $departmentRankings->pluck('total');

        // Feedback
        $feedbackCount = Feedback::count();
        $feedbacks = Feedback::all();
        $chatRatings = ChatRating::latest()->get();

        $chatRatingCounts = collect(range(1, 5))
            ->mapWithKeys(fn ($star) => [$star => 0])
            ->all();

        foreach ($chatRatings as $chatRating) {
            $stars = (int) $chatRating->stars;

            if (isset($chatRatingCounts[$stars])) {
                $chatRatingCounts[$stars]++;
            }
        }

        $chatRatingsTotal = array_sum($chatRatingCounts);
        $chatRatingsAverage = $chatRatingsTotal > 0
            ? round(
                collect($chatRatingCounts)->reduce(
                    fn ($carry, $count, $stars) => $carry + ($count * (int) $stars),
                    0
                ) / $chatRatingsTotal,
                1
            )
            : 0;

        // Clients (merged with display_name and client_type)
        $students = Student::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'student' as client_type")
        )->get();

        $faculty = Faculty::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'faculty' as client_type")
        )->get();

        $alumni = Alumni::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'alumni' as client_type")
        )->get();

        $others = Other::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'other' as client_type")
        )->get();

        $clients = $students->concat($faculty)->concat($alumni)->concat($others);

        // Complaint summary
        $pendingCount  = Complaint::count();
        $solvedCount   = ComplaintSolved::count();
        $spammedCount  = RejectedComplaint::count();
        $complaintCount = Complaint::count();
        $timePeriodLabel = "Overall";

        return view('admin-complaint-dashboard', compact(
            'complaintCount', 'timePeriodLabel', 'feedbackCount', 'feedbacks',
            'pendingCount', 'solvedCount', 'spammedCount', 'clients',
            'deptLabels', 'deptCounts', 'chatRatingCounts', 'chatRatingsTotal',
            'chatRatingsAverage'
        ));
    }



    // IO Dashboard (no complaints, no feedback)
    public function ioDashboard()
    {
        // Top 10 Departments (complaints + solved)
        $departmentRankings = DB::table(DB::raw("
            (
                SELECT department FROM complaints
                UNION ALL
                SELECT department FROM complaint_solved
            ) AS all_departments
        "))
        ->select('department', DB::raw('COUNT(*) as total'))
        ->groupBy('department')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

        $deptLabels = $departmentRankings->pluck('department');
        $deptCounts = $departmentRankings->pluck('total');

        // Complaint summary counts (view-only for IO)
        $pendingCount  = Complaint::count();
        $solvedCount   = ComplaintSolved::count();
        $spammedCount  = RejectedComplaint::count();

        // Feedback (for charts)
        $feedbacks = Feedback::all();
        $chatRatings = ChatRating::latest()->get();

        $chatRatingCounts = collect(range(1, 5))
            ->mapWithKeys(fn ($star) => [$star => 0])
            ->all();

        foreach ($chatRatings as $chatRating) {
            $stars = (int) $chatRating->stars;

            if (isset($chatRatingCounts[$stars])) {
                $chatRatingCounts[$stars]++;
            }
        }

        $chatRatingsTotal = array_sum($chatRatingCounts);
        $chatRatingsAverage = $chatRatingsTotal > 0
            ? round(
                collect($chatRatingCounts)->reduce(
                    fn ($carry, $count, $stars) => $carry + ($count * (int) $stars),
                    0
                ) / $chatRatingsTotal,
                1
            )
            : 0;

        // Build summary for Google Charts (same logic as admin)
        $summary = [];
        foreach ($feedbacks as $fb) {
            $client = $fb->client_type;

            if (!isset($summary[$client])) {
                $summary[$client] = [
                    'Strongly Agree' => 0,
                    'Agree' => 0,
                    'Neutral' => 0,
                    'Disagree' => 0,
                    'Strongly Disagree' => 0,
                ];
            }

            $answers = json_decode($fb->sqd_answers, true) ?? [];
            $total = array_sum($answers);
            $average = count($answers) > 0 ? $total / count($answers) : 0;

            if ($average >= 4.5) {
                $summary[$client]['Strongly Agree']++;
            } elseif ($average >= 3.5) {
                $summary[$client]['Agree']++;
            } elseif ($average >= 2.5) {
                $summary[$client]['Neutral']++;
            } elseif ($average >= 1.5) {
                $summary[$client]['Disagree']++;
            } else {
                $summary[$client]['Strongly Disagree']++;
            }
        }

        // Clients (merged)
        $students = Student::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'student' as client_type")
        )->get();

        $faculty = Faculty::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'faculty' as client_type")
        )->get();

        $alumni = Alumni::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'alumni' as client_type")
        )->get();

        $others = Other::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'other' as client_type")
        )->get();

        $clients = $students->concat($faculty)->concat($alumni)->concat($others);

        // Solved inquiries count
        $clientChatsCount = Message::where('sender', 'system')
            ->where('message', 'like', '%I think you are satisfied or solved your inquiry%')
            ->count();

        return view('io.dashboard', compact(
            'clientChatsCount',
            'clients',
            'pendingCount',
            'solvedCount',
            'spammedCount',
            'deptLabels',
            'deptCounts',
            'feedbacks',
            'summary',
            'chatRatingCounts',
            'chatRatingsTotal',
            'chatRatingsAverage'
        ));
    }

    // AUDIT Dashboard (same layout/data style as IO Dashboard)
    public function auditDashboard()
    {
        // Top 10 Departments (complaints + solved)
        $departmentRankings = DB::table(DB::raw("
            (
                SELECT department FROM complaints
                UNION ALL
                SELECT department FROM complaint_solved
            ) AS all_departments
        "))
        ->select('department', DB::raw('COUNT(*) as total'))
        ->groupBy('department')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

        $deptLabels = $departmentRankings->pluck('department');
        $deptCounts = $departmentRankings->pluck('total');

        // Complaint summary counts
        $pendingCount  = Complaint::count();
        $solvedCount   = ComplaintSolved::count();
        $spammedCount  = RejectedComplaint::count();

        // Feedback (optional, if your Audit dashboard will also show charts)
        $feedbacks = Feedback::all();

        // Build summary for Google Charts (same logic as IO)
        $summary = [];
        foreach ($feedbacks as $fb) {
            $client = $fb->client_type;

            if (!isset($summary[$client])) {
                $summary[$client] = [
                    'Strongly Agree' => 0,
                    'Agree' => 0,
                    'Neutral' => 0,
                    'Disagree' => 0,
                    'Strongly Disagree' => 0,
                ];
            }

            $answers = json_decode($fb->sqd_answers, true) ?? [];
            $total = array_sum($answers);
            $average = count($answers) > 0 ? $total / count($answers) : 0;

            if ($average >= 4.5) {
                $summary[$client]['Strongly Agree']++;
            } elseif ($average >= 3.5) {
                $summary[$client]['Agree']++;
            } elseif ($average >= 2.5) {
                $summary[$client]['Neutral']++;
            } elseif ($average >= 1.5) {
                $summary[$client]['Disagree']++;
            } else {
                $summary[$client]['Strongly Disagree']++;
            }
        }

        // Clients (merged) - for client pie table
        $students = Student::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'student' as client_type")
        )->get();

        $faculty = Faculty::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'faculty' as client_type")
        )->get();

        $alumni = Alumni::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'alumni' as client_type")
        )->get();

        $others = Other::select(
            'id as client_id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(CONCAT(middle_initial, '. '), ''), last_name,
                CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix) ELSE '' END) as display_name"),
            DB::raw("'other' as client_type")
        )->get();

        $clients = $students->concat($faculty)->concat($alumni)->concat($others);

        // Optional: solved inquiries count (same logic as IO)
        $clientChatsCount = Message::where('sender', 'system')
            ->where('message', 'like', '%I think you are satisfied or solved your inquiry%')
            ->count();

        // Return the Audit dashboard view (make sure this blade exists)
        return view('audit.dashboard', compact(
            'clientChatsCount',
            'clients',
            'pendingCount',
            'solvedCount',
            'spammedCount',
            'deptLabels',
            'deptCounts',
            'feedbacks',
            'summary'
        ));
    }

    public function auditComplaints()
    {
        $complaints = Complaint::latest()->get(); // or ->where('status','Pending')
        return view('audit.complaints.index', compact('complaints'));
    }

    public function auditRejectedComplaints()
    {
        $rejectedComplaints = RejectedComplaint::latest()->get();
        return view('audit.complaints.rejected', compact('rejectedComplaints'));
    }

    // optional solved page (only if you created that blade)
    public function auditSolvedComplaints()
    {
        $solvedComplaints = ComplaintSolved::latest()->get();
        return view('audit.complaints.solved', compact('solvedComplaints'));
    }

    public function auditMarkComplaintSolved(Request $request, $id)
    {
        $request->validate([
            'sent_to'      => 'required|string|max:255',
            'sent_date'    => 'required|date',
            'action_taken' => 'required|string',
            'action_date'  => 'required|date|after_or_equal:sent_date',
        ]);

        // Find in complaints table first, otherwise in reviews table
        $record = Complaint::find($id) ?? Review::findOrFail($id);

        $solved = ComplaintSolved::create([
            'name'           => $record->name ?? '',
            'email'          => $record->email,
            'message'        => $record->message,
            'client_type'    => $record->client_type,
            'department'     => $record->department,
            'contact_number' => $record->contact_number,
            'image'          => $record->image,
            'video'          => $record->video,
            'sent_to'        => $request->sent_to,
            'sent_date'      => $request->sent_date,
            'action_taken'   => $request->action_taken,
            'action_date'    => $request->action_date,
            'status'         => 'Solved',
            'created_at'     => now(),
        ]);

       $targetClientId = $record->client_id;

        // 
        if (empty($targetClientId)) {
            $targetClientId = $this->resolveClientIdByTypeAndEmail($record->client_type, $record->email);
        }

        $userType = strtolower(trim($record->client_type)); 

        if (!empty($targetClientId) && !empty($record->client_type)) {
            Notification::create([
                'client_id' => $targetClientId,
                'user_type' => $record->client_type,
                'title'     => 'Complaint Solved',
                'message'   =>
                    "Your complaint has been resolved.\n\n" .
                    "Sent to: {$request->sent_to}\n" .
                    "Sent date: {$request->sent_date}\n" .
                    "Action taken: {$request->action_taken}\n" .
                    "Action date: {$request->action_date}",
                'is_read'   => 0,
            ]);
        }

        // Delete original record
        $record->delete();

        // Send email notification (optional: include new fields in email view)
        Mail::send('emails.complaint-solved', ['complaint' => $solved], function ($m) use ($solved) {
            $m->to($solved->email, $solved->name)
            ->subject('Your Complaint Has Been Solved');
        });

        return redirect()->back()->with('success', 'Complaint has been marked as solved and the complainant notified.');
    }

    public function auditRejectComplaint(Request $request, $id)
    {
        $request->validate([
            'reason'        => 'required',
            'other_reason'  => 'required_if:reason,other',
            'admin_message' => 'required|string|max:2000', 
        ]);

        $finalReason = $request->reason === 'other'
            ? $request->other_reason
            : $request->reason;

        $adminMessage = $request->admin_message;

        $complaint = Complaint::findOrFail($id);

        $spam = RejectedComplaint::create([
            'name'           => $complaint->name ?? '',
            'email'          => $complaint->email,
            'client_type'    => $complaint->client_type,
            'department'     => $complaint->department,
            'contact_number' => $complaint->contact_number,
            'message'        => $complaint->message,
            'image'          => $complaint->image,
            'video'          => $complaint->video,
            'status'         => 'Rejected',
            'spam_reason'    => $finalReason,
        ]);

        $userType = strtolower(trim($complaint->client_type));
        $clientId = $complaint->client_id ?? null;

        if (empty($clientId)) {
            $clientId = $this->resolveClientIdByTypeAndEmail($complaint->client_type, $complaint->email);
        }

        // 1st spam => 7 days, 2nd => permanent
        if (!empty($clientId) || !empty($complaint->email)) {

            $banQuery = ClientBan::where('client_type', $userType);

            if (!empty($clientId)) {
                $banQuery->where('client_id', $clientId);
            } else {
                $banQuery->where('email', $complaint->email);
            }

            $ban = $banQuery->first();

            if (!$ban) {
                $ban = ClientBan::create([
                    'client_type' => $userType,
                    'client_id'   => $clientId,
                    'email'       => $complaint->email,
                    'strikes'     => 0,
                ]);
            }

            $ban->strikes = (int) $ban->strikes + 1;
            $ban->last_reason  = $finalReason;
            $ban->last_message = $adminMessage;

            if ($ban->strikes === 1) {
                $ban->banned_until = now()->addDays(7);
                $ban->is_permanent = false;
                $banText = "Your account has been temporarily banned for 1 week. You may login again after: " .
                    $ban->banned_until->format('Y-m-d h:i A');
            } else {
                $ban->is_permanent = true;
                $ban->banned_until = null;
                $banText = "Your account has been permanently banned due to repeated spam complaints.";
            }

            $ban->save();

            if (!empty($clientId)) {
                Notification::create([
                    'client_id' => $clientId,
                    'user_type' => $userType,
                    'title'     => $ban->is_permanent ? 'Account Permanently Banned' : 'Account Temporarily Banned',
                    'message'   => $banText . "\n\nReason: {$finalReason}\n\nMessage: {$adminMessage}",
                    'is_read'   => 0,
                ]);
            }

            try {
                Mail::to($complaint->email)->send(
                    new \App\Mail\ComplaintSpamNotice($complaint, $finalReason, $adminMessage, $banText)
                );
            } catch (\Throwable $e) {
                Log::error("Spam notice email failed: " . $e->getMessage());
            }
        }

        $complaint->delete();

        return redirect()->back()->with('success', 'Complaint moved to spam list, user notified, and ban applied.');
    }

    public function auditFeedback()
    {
        $feedbacks = Feedback::all();
        $chatRatings = ChatRating::latest()->get();
        return view('audit.feedback.index', compact('feedbacks', 'chatRatings'));
    }



    // Admin Profile Page
    public function profile()
    {
        $admins = AdminAccount::all();
        return view('admin.admin-complaint-dashboard-profile', compact('admins'));
    }

    // Add Admin Profile
    public function addProfile(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admin_account,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:super_admin,io,audit',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $suffix = $request->suffix;
        if ($suffix === 'Other' && $request->filled('other_suffix')) {
            $suffix = $request->other_suffix;
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploaded_img', $imageName, 'public');
        }

        AdminAccount::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'suffix' => $suffix,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imageName,
            'role' => $request->role, 
        ]);

        return redirect()->route('admin.profile')->with('message', 'Admin profile added successfully.');
    }

    // Edit Admin Profile
    public function update(Request $request, $id)
    {
        $admin = AdminAccount::findOrFail($id);

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'nullable|in:super_admin,io,audit',
        ]);

        // Handle "N.A" so it gets saved properly
        if ($request->input('suffix') === 'N.A') {
            $validatedData['suffix'] = 'N.A';
        } elseif ($request->filled('suffix')) {
            $validatedData['suffix'] = $request->input('suffix');
        } else {
            $validatedData['suffix'] = null;
        }

        // Handle password (keep current if blank)
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Handle image replacement
        if ($request->hasFile('image')) {
            if ($admin->image && Storage::disk('public')->exists('uploaded_img/' . $admin->image)) {
                Storage::disk('public')->delete('uploaded_img/' . $admin->image);
            }

            $image = $request->file('image');
            $validatedData['image'] = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploaded_img', $validatedData['image'], 'public');
        } else {
            $validatedData['image'] = $admin->image;
        }

        $user = Auth::guard('admin')->user();
        if (!$user || $user->role !== 'super_admin') {
            unset($validatedData['role']);
        } else {
            // if role not sent, keep old
            if (!$request->filled('role')) unset($validatedData['role']);
        }

        $admin->update($validatedData);

        return redirect()->route('admin.profile')->with('success', 'Admin details updated successfully.');
    }


    // Delete Admin Profile
    public function deleteProfile($id)
    {
        $admin = AdminAccount::findOrFail($id);

        if ($admin->image && Storage::disk('public')->exists('uploaded_img/' . $admin->image)) {
            Storage::disk('public')->delete('uploaded_img/' . $admin->image);
        }

        $admin->delete();

        return redirect()->route('admin.profile')->with('message', 'Admin profile deleted successfully.');
    }

    // Fetch all admin profiles (AJAX/JSON)
    public function fetchProfiles()
    {
        return response()->json(['data' => AdminAccount::all()]);
    }

    // Get a single admin profile
    public function getProfile($id)
    {
        $profile = AdminAccount::find($id);

        return $profile
            ? response()->json($profile)
            : response()->json(['error' => 'Admin profile not found.'], 404);
    }


    // =========================
    // IO PROFILES (IO role only)
    // =========================
    public function ioProfiles()
    {
        // show ONLY io role accounts
        $ios = AdminAccount::where('role', 'io')->get();

        // your view file: resources/views/io/profile.blade.php
        return view('io.profile', compact('ios'));
    }

    public function addIoProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admin_account,email',
            'password' => 'required|confirmed|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploaded_img', $imageName, 'public');
        }

        AdminAccount::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imageName,
            'role' => 'io', // force IO role
        ]);

        return redirect()->route('io.profile')->with('message', 'IO account added successfully.');
    }

    public function updateIoProfile(Request $request, $id)
    {
        $io = AdminAccount::where('role', 'io')->findOrFail($id);

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle suffix properly
        if ($request->input('suffix') === 'N.A') {
            $validatedData['suffix'] = 'N.A';
        } elseif ($request->filled('suffix')) {
            $validatedData['suffix'] = $request->input('suffix');
        } else {
            $validatedData['suffix'] = null;
        }

        // Handle password (keep current if blank)
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Handle image replacement
        if ($request->hasFile('image')) {
            if ($io->image && Storage::disk('public')->exists('uploaded_img/' . $io->image)) {
                Storage::disk('public')->delete('uploaded_img/' . $io->image);
            }

            $image = $request->file('image');
            $validatedData['image'] = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploaded_img', $validatedData['image'], 'public');
        } else {
            $validatedData['image'] = $io->image;
        }

        // make sure role stays io
        $validatedData['role'] = 'io';

        $io->update($validatedData);

        return redirect()->route('io.profile')->with('success', 'IO details updated successfully.');
    }

    public function deleteIoProfile($id)
    {
        $io = AdminAccount::where('role', 'io')->findOrFail($id);

        if ($io->image && Storage::disk('public')->exists('uploaded_img/' . $io->image)) {
            Storage::disk('public')->delete('uploaded_img/' . $io->image);
        }

        $io->delete();

        return redirect()->route('io.profile')->with('message', 'IO account deleted successfully.');
    }


    // =========================
    // AUDIT PROFILES (audit role only)
    // =========================
    public function auditProfiles()
    {
        // show ONLY audit role accounts
        $audits = AdminAccount::where('role', 'audit')->get();

        // your view file: resources/views/audit/profile.blade.php
        return view('audit.profile', compact('audits'));
    }

    public function addAuditProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'other_suffix' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admin_account,email', // ✅ correct
            'password' => 'required|confirmed|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ✅ handle "Other" suffix
        $suffix = $request->suffix;
        if ($suffix === 'Other' && $request->filled('other_suffix')) {
            $suffix = $request->other_suffix;
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploaded_img', $imageName, 'public');
        }

        AdminAccount::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'suffix' => $suffix,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imageName,
            'role' => 'audit',
        ]);

        return redirect()->route('audit.profile')->with('message', 'Audit account added successfully.');
    }

    public function updateAuditProfile(Request $request, $id)
    {
        $audit = AdminAccount::where('role', 'audit')->findOrFail($id);

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle suffix properly
        if ($request->input('suffix') === 'N.A') {
            $validatedData['suffix'] = 'N.A';
        } elseif ($request->filled('suffix')) {
            $validatedData['suffix'] = $request->input('suffix');
        } else {
            $validatedData['suffix'] = null;
        }

        // Handle password (keep current if blank)
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Handle image replacement
        if ($request->hasFile('image')) {
            if ($audit->image && Storage::disk('public')->exists('uploaded_img/' . $audit->image)) {
                Storage::disk('public')->delete('uploaded_img/' . $audit->image);
            }

            $image = $request->file('image');
            $validatedData['image'] = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploaded_img', $validatedData['image'], 'public');
        } else {
            $validatedData['image'] = $audit->image;
        }

        // make sure role stays audit
        $validatedData['role'] = 'audit';

        $audit->update($validatedData);

        return redirect()->route('audit.profile')->with('success', 'Audit details updated successfully.');
    }

    public function deleteAuditProfile($id)
    {
        $audit = AdminAccount::where('role', 'audit')->findOrFail($id);

        if ($audit->image && Storage::disk('public')->exists('uploaded_img/' . $audit->image)) {
            Storage::disk('public')->delete('uploaded_img/' . $audit->image);
        }

        $audit->delete();

        return redirect()->route('audit.profile')->with('message', 'Audit profile deleted successfully.');
    }



    // Manage Complaints
    public function complaints()
    {
        $complaints = Complaint::where('status', 'Pending')->get();
        return view('admin.complaints', compact('complaints'));
    }

    // Generic process method
    public function process()
    {
        return redirect()->route('admin.dashboard')->with('message', 'Process completed!');
    }

    public function inquiries()
    {
        // Get latest messages (filtered by client only)
        $inquiries = Message::whereNotIn('sender', ['admin', 'system'])->latest()->paginate(10);

        return view('admin.inquiries', compact('inquiries'));
    }

    public function getClientChatsCount()
    {
        // Count only client messages (exclude admin/system)
        $totalClientChats = Message::whereNotIn('sender', ['admin', 'system'])->count();

        return response()->json([
            'success' => true,
            'count' => $totalClientChats
        ]);
    }

    public function getComplaintsCount(Request $request)
    {
        // Default to 'all' if not provided
        $period = $request->input('period', 'all'); 
        $month = $request->input('month'); // optional month filter

        $query = Complaint::query();

        switch ($period) {
            case 'week':
                $query->whereBetween('created_at', [
                    \Carbon\Carbon::now()->startOfWeek(),
                    \Carbon\Carbon::now()->endOfWeek()
                ]);
                break;

            case 'month':
                if ($month) {
                    $query->whereMonth('created_at', $month)
                        ->whereYear('created_at', \Carbon\Carbon::now()->year);
                } else {
                    $query->whereMonth('created_at', \Carbon\Carbon::now()->month)
                        ->whereYear('created_at', \Carbon\Carbon::now()->year);
                }
                break;

            case 'year':
                $query->whereYear('created_at', \Carbon\Carbon::now()->year);
                break;

            case 'all':
            default:
                // No filter, get all complaints
                break;
        }

        $count = $query->count();

        // Determine month name if a specific month is selected
        $monthName = $month ? \Carbon\Carbon::create()->month($month)->format('F') : null;

        return response()->json([
            'success' => true,
            'count' => $count,
            'period' => $period,
            'month' => $monthName, // returns month name or null
        ]);
    }

   public function markSolved(Request $request)
{
    $request->validate([
        'client_id' => 'required',
        'client_type' => 'required',
    ]);

    $clientId = $request->client_id;
    $clientType = strtolower($request->client_type);

    // Mark ALL previous messages as solved
    Message::where('client_id', $clientId)
        ->where('client_type', $clientType)
        ->update(['solved' => 1]);

    // Optional: Send system message as confirmation
    $messageText = "I think you are satisfied or solved your inquiry, thank you for your time. 
                    You can chat again if you have another inquiry. 
                    Provide feedback here: <a href='" . route('feedback.form') . "' target='_blank' 
                    style='text-decoration: underline; color: blue;'>Feedback Form</a>";

    Message::create([
        'client_id' => $clientId,
        'client_type' => $clientType,
        'sender' => 'system',
        'message' => $messageText,
        'unread_for_admin' => false,
        'solved' => 1
    ]);

    // Mark previous messages as read (optional)
    Message::where('client_id', $clientId)
        ->where('client_type', $clientType)
        ->where('sender', '!=', 'admin')
        ->update(['unread_for_admin' => false]);

    return response()->json(['success' => true]);
}


public function getSolvedClientsCount()
{
    $messageSnippet = "I think you are satisfied or solved your inquiry";

    $count = Message::where('sender', 'system')
        ->where('message', 'like', "%{$messageSnippet}%")
        ->count();

    return response()->json([
        'success' => true,
        'count' => $count
    ]);
}


private function resolveClientIdByTypeAndEmail(string $clientType, ?string $email): ?int
{
    if (!$email) return null;

    $type = strtolower(trim($clientType));

    return match ($type) {
        'student' => Student::where('email', $email)->value('id'),
        'faculty' => Faculty::where('email', $email)->value('id'),
        'alumni'  => Alumni::where('email', $email)->value('id'),
        'other', 'others' => Other::where('email', $email)->value('id'),
        default   => null,
    };
}



}
