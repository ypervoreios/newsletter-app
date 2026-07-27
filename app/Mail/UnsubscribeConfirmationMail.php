<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnsubscribeConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $recipient;

    public function __construct($contact, $recipient = null)
    {
        $this->contact = $contact;
        $this->recipient = $recipient;
    }

    public function build()
    {
        return $this->subject('You have been unsubscribed')
            ->view('emails.unsubscribe');
    }
}
