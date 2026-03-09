<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintSolvedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $solved;

    public function __construct($solved)
    {
        $this->solved = $solved;
    }

    public function build()
    {
        return $this->subject('Your Complaint has been Solved')
                    ->view('emails.complaint_solved')
                    ->with([
                        'name' => $this->solved->name,
                        'messageContent' => $this->solved->message,
                        'type' => $this->solved->type,
                    ]);
    }
}

?>
