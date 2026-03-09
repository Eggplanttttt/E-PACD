<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name; // To hold the name of the user

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name; // Store the name to be used in the email view
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank You for Your Feedback') // Set the subject
                    ->view('emails.thankyou') // Set the email view
                    ->with(['name' => $this->name]); // Pass the name to the email view
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // No attachments in this case
    }
}
