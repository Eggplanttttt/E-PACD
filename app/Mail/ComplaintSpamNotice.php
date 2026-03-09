<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintSpamNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;
    public $reason;
    public $adminMessage;
    public $banText;

    public function __construct($complaint, string $reason, ?string $adminMessage = null, ?string $banText = null)
    {
        $this->complaint = $complaint;
        $this->reason = $reason;
        $this->adminMessage = $adminMessage;
        $this->banText = $banText;
    }

    public function build()
    {
        return $this->subject('Complaint Reviewed (E-PACD)')
                    ->view('emails.complaint-spam-notice');
    }
}