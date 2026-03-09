<?php

namespace App\Http\Controllers;


use App\Models\Complaint;
use App\Models\ComplaintSolved;
use App\Models\Review;
use App\Models\RejectedComplaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplaintThankYouMail;
use App\Mail\ComplaintReply;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exports\SolvedComplaintsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Notification;
use App\Models\Student;
use App\Models\ClientBan;
use Carbon\Carbon;

class ComplaintController extends Controller
{

     // Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $otp = rand(100000, 999999);

        // Store OTP in session with expiration (5 minutes)
        Session::put('email_otp', $otp);
        Session::put('otp_email', $request->email);
        Session::put('otp_expire', now()->addMinutes(5));

        try {
            // Use Mail::raw for simplicity
            Mail::raw("Your OTP code is: {$otp}. It will expire in 5 minutes.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Your OTP Code');
            });

            return response()->json(['message' => 'OTP sent successfully'], 200);
        } catch (\Exception $e) {
            Log::error("OTP send failed: " . $e->getMessage());
            return response()->json(['message' => 'Failed to send OTP.'], 500);
        }
    }


    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $sessionOtp = Session::get('email_otp');
        $otpExpire = Session::get('otp_expire');
        $sessionEmail = Session::get('otp_email');

        if (!$sessionOtp || !$sessionEmail || now()->gt($otpExpire)) {
            return response()->json(['valid' => false, 'message' => 'OTP expired.'], 200);
        }

        if ($request->otp == $sessionOtp) {
            // OTP valid, clear session
            Session::forget(['email_otp', 'otp_email', 'otp_expire']);
            return response()->json(['valid' => true, 'message' => 'OTP verified successfully'], 200);
        }

        return response()->json(['valid' => false, 'message' => 'Invalid OTP'], 200);
    }



    // Show all complaints
    public function index()
    {
        $complaints = Complaint::orderBy('id', 'asc')->get();
        return view('admin.complaints', compact('complaints'));
    }

    // Accept complaint (move to reviews table)
    public function accept($id)
    {
        $complaint = Complaint::findOrFail($id);

        Review::create([
            'client_id'      => $complaint->client_id,   
            'name'           => $complaint->name,
            'email'          => $complaint->email,
            'client_type'    => $complaint->client_type,
            'department'     => $complaint->department,
            'contact_number' => $complaint->contact_number,
            'message'        => $complaint->message,
            'image'          => $complaint->image,
            'video'          => $complaint->video,
            'status'         => 'under_review',
        ]);

        $complaint->delete();

        return redirect()->route('admin.complaints')->with('success', 'Complaint moved to review.');
    }

    // Reorder complaint IDs (if necessary)
    private function reorderComplaints()
    {
        $complaints = Complaint::orderBy('id', 'asc')->get();
        $i = 1;     
        foreach ($complaints as $complaint) {
            $complaint->update(['id' => $i]);
            $i++;
        }
    }

    // Store a new complaint
    public function store(Request $request)
        {
            $validated = $request->validate([
                'name'        => 'nullable|string|max:255',
                'email'       => 'required|email|max:255',
                'message'     => 'required|string',
                'client_type' => 'required|string|max:255',
                'department'  => 'required|string|max:255',
                'contact'     => 'required|string|max:255',
                'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'video'       => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:51200',
            ]);

            $data = [
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'message'       => $validated['message'],
                'client_type'   => $validated['client_type'],
                'department'    => $validated['department'],
                'contact_number'=> $validated['contact'],
                'status'        => 'Pending',
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('complaints/images', 'public');
            }

            if ($request->hasFile('video')) {
                $data['video'] = $request->file('video')->store('complaints/videos', 'public');
            }

            $complaint = \App\Models\Complaint::create($data);

            // Send Thank You Email
            Mail::to($complaint->email)->send(new ComplaintThankYouMail($complaint->name));

            return redirect()->back()->with('success', 'Your complaint has been submitted successfully. A thank you email has been sent.');
        }

    // Complaints under review
    public function reviewingComplaints()
    {
        $complaints = Review::where('status', 'under_review')->get();
        return view('admin.reviewing-complaints', compact('complaints'));
    }

    // Mark a review/complaint as solved
    public function markAsSolved(Request $request, $id)
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

        // fallback: if old records have no client_id, try to locate by email (Student only)
        if (empty($targetClientId) && $record->client_type === 'Student') {
            $student = Student::where('email', $record->email)->first();
            $targetClientId = $student?->id;
        }

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


    // List all solved complaints
    public function solvedList()
    {
        $solvedComplaints = ComplaintSolved::all();
        return view('admin.solved-complaints', compact('solvedComplaints'));
    }

    // List all rejected complaints
    public function rejectedList()
    {
        $rejectedComplaints = RejectedComplaint::all();
        return view('admin.rejected-complaints', compact('rejectedComplaints'));
    }

    // List all complaints (from reviews table)
    public function complaints()
    {
        $complaints = Review::all();
        return view('admin.complaints', compact('complaints'));
    }

    public function reject(Request $request, $id)
    {
        // Validate reason + admin message
        $request->validate([
            'reason'         => 'required',
            'other_reason'   => 'required_if:reason,other',
            'admin_message'  => 'required|string|max:2000',
        ]);

        $finalReason = $request->reason === 'other'
            ? $request->other_reason
            : $request->reason;

        $adminMessage = $request->admin_message;

        // Find record from Complaint or Review
        $record = Complaint::find($id) ?? Review::findOrFail($id);

        // 1) Save to spam table (RejectedComplaint)
        RejectedComplaint::create([
            'name'           => $record->name ?? '',
            'email'          => $record->email,
            'client_type'    => $record->client_type,
            'department'     => $record->department,
            'contact_number' => $record->contact_number,
            'message'        => $record->message,
            'image'          => $record->image,
            'video'          => $record->video,
            'status'         => 'Rejected',
            'spam_reason'    => $finalReason,
            // If you want to store admin message too, add column first:
            // 'admin_message'  => $adminMessage,
        ]);

        // 2) Apply ban (1st spam => 7 days, 2nd => permanent)
        $clientType = $record->client_type;
        $clientId   = $record->client_id ?? null;
        $email      = $record->email ?? null;

        // Fallback: if no client_id, try to find by email (Student only)
        if (empty($clientId) && $clientType === 'Student' && !empty($email)) {
            $student = Student::where('email', $email)->first();
            $clientId = $student?->id;
        }

        // Upsert ban record (prefer client_id, fallback email)
        $banQuery = ClientBan::where('client_type', $clientType);

        if (!empty($clientId)) {
            $banQuery->where('client_id', $clientId);
        } elseif (!empty($email)) {
            $banQuery->where('email', $email);
        }

        $ban = $banQuery->first();

        if (!$ban) {
            $ban = ClientBan::create([
                'client_type' => $clientType,
                'client_id'   => $clientId,
                'email'       => $email,
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

        // 3) Create in-app notification (only if we have a client_id)
        if (!empty($clientId)) {
            $title = $ban->is_permanent ? 'Account Permanently Banned' : 'Account Temporarily Banned';
            $msg   = $banText . "\n\nReason: {$finalReason}\n\nMessage: {$adminMessage}";

            Notification::create([
                'client_id' => $clientId,
                'user_type' => $clientType,
                'title'     => $title,
                'message'   => $msg,
                'is_read'   => 0,
            ]);
        }

        // 4) Email the user
        try {
            Mail::to($record->email)->send(
                new \App\Mail\ComplaintSpamNotice($record, $finalReason, $adminMessage, $banText)
            );
        } catch (\Throwable $e) {
            Log::error("Spam notice email failed: " . $e->getMessage());
        }

        // 5) Delete original record
        $record->delete();

        return redirect()->back()
         ->with('success', 'Complaint moved to spam list, user notified, and ban applied.');
    }



    public function getComplaintsCount(Request $request)
    {
        $type  = $request->input('type');   // days, weeks, months, years, month (submenu), all
        $value = (int) $request->input('value', 1);
        $month = $request->input('month');  // from month submenu

        $query = Complaint::query();

        if ($type !== 'all') {

            switch ($type) {

                case 'days':
                    $query->where('created_at', '>=', now()->subDays($value));
                    break;

                case 'weeks':
                    $query->where('created_at', '>=', now()->subWeeks($value));
                    break;

                case 'months':
                    $query->where('created_at', '>=', now()->subMonths($value));
                    break;

                case 'years':
                    $query->where('created_at', '>=', now()->subYears($value));
                    break;

                case 'month': // Month submenu
                    if ($month) {
                        $monthNumber = \Carbon\Carbon::parse($month)->month;
                        $query->whereMonth('created_at', $monthNumber);
                    }
                    break;
            }
        }

        return response()->json([
            'count' => $query->count(),
            'success' => true,
        ]);
    }

    public function exportSolvedCsv()
    {
        $fileName = 'solved-complaints-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $columns = [
            'Name',
            'Email',
            'Client Type',
            'Department',
            'Contact Number',
            'Message',
            'Type',
            'Sent To',
            'Sent Date',
            'Action Taken',
            'Action Date',
            'Status',
            'Created At',
        ];

        $callback = function () use ($columns) {
            $handle = fopen('php://output', 'w');

            // ✅ Excel UTF-8 fix (prevents weird characters)
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // header row
            fputcsv($handle, $columns);

            // data
            $rows = \App\Models\ComplaintSolved::orderBy('created_at', 'desc')->get();

            foreach ($rows as $r) {
                fputcsv($handle, [
                    $r->name,
                    $r->email,
                    $r->client_type,
                    $r->department,
                    $r->contact_number,
                    $r->message,
                    $r->type,
                    $r->sent_to,
                    $r->sent_date,
                    $r->action_taken,
                    $r->action_date,
                    $r->status,
                    optional($r->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

}
