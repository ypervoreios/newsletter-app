<?php

namespace App\Mail;

use App\Models\Campaign;
use App\Models\CampaignRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(
        public Campaign $campaign,
        public ?CampaignRecipient $recipient = null
    ) {
    }


    public function build()
    {
        $unsubscribeUrl = null;
        if ($this->recipient && $this->recipient->token) {
            $unsubscribeUrl = route('campaigns.unsubscribe', $this->recipient->token);
        }

        $mail = $this->subject($this->campaign->subject)
            ->view('emails.campaign')
            ->with([
                'campaign' => $this->campaign,
                'recipient' => $this->recipient,
                'unsubscribeUrl' => $unsubscribeUrl,
            ]);

        // Add List-Unsubscribe header when we have a recipient token so mail clients can show unsubscribe UI
        if ($unsubscribeUrl) {
            $mail->withSwiftMessage(function ($message) use ($unsubscribeUrl) {
                $headers = $message->getHeaders();
                $headers->addTextHeader('List-Unsubscribe', "<{$unsubscribeUrl}>");
            });
        }

        return $mail;
    }
}
