<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ComplaintThankYouMail;
use App\Models\Notification;
use App\Models\ClientBan;

class StudentComplaintController extends Controller
{
    public function store(Request $request)
    {
        $user = auth('student')->user();

        $ban = ClientBan::where('client_type', 'Student')
            ->where('client_id', $user->id)
            ->first();

        if ($ban) {
            if ($ban->is_permanent) {
                abort(403, 'Your account is permanently banned.');
            }

            if ($ban->banned_until && now()->lt($ban->banned_until)) {
                $until = $ban->banned_until->format('Y-m-d h:i A');
                abort(403, "You are banned until {$until}.");
            }
        }

        abort_if(!$user, 403, 'Unauthorized.');

        $validated = $request->validate([
            'name'        => 'nullable|string|max:255',
            'department'  => 'required|string|max:255',
            'contact'     => 'required|string|max:255',
            'message'     => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'video'       => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:51200',
        ]);

        $data = [
            'client_id'      => $user->id,
            'name'           => $validated['name'] ?? 'Anonymous',
            'email'          => $user->email,
            'client_type'    => 'Student',
            'department'     => $validated['department'],
            'contact_number' => $validated['contact'],
            'message'        => $validated['message'],
            'status'         => 'Pending',
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('complaints/images', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('complaints/videos', 'public');
        }

        $complaint = Complaint::create($data);

        // ✅ Universal notification
        Notification::create([
            'client_id' => $user->id,
            'user_type' => 'Student',
            'title'     => 'Complaint Submitted',
            'message'   => 'Your complaint has been successfully submitted and is now under review.',
            'is_read'   => false,
        ]);

        // Thank you email
        try {
            Mail::to($complaint->email)->send(new ComplaintThankYouMail($complaint->name));
        } catch (\Throwable $e) {
            Log::error("Thank you email failed: " . $e->getMessage());
        }

        return back()->with('success', 'Your complaint has been submitted successfully.');
    }
}