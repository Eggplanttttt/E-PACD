<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintReply extends Mailable
{
    use Queueable, SerializesModels;

    public $replyMessage;

    public function __construct($replyMessage)
    {
        $this->replyMessage = $replyMessage;
    }

    public function build()
    {
        return $this->subject('Response to your Complaint')
                    ->view('emails.complaint_reply');
    }
}

?>