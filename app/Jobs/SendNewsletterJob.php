<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignRecipient;
use App\Mail\CampaignMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\MailSetting;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;
    public $recipient;

    public function __construct(Campaign $campaign, CampaignRecipient $recipient)
    {
        $this->campaign = $campaign;
        $this->recipient = $recipient;
    }

    public function handle()
    {
        $this->recipient->loadMissing('contact');

        // Load mail settings from DB (if available) so queued jobs use current SMTP
        $settings = MailSetting::first();
        if ($settings) {
            Config::set('mail.mailers.smtp.host', $settings->host);
            if ($settings->port) Config::set('mail.mailers.smtp.port', $settings->port);
            Config::set('mail.mailers.smtp.encryption', $settings->encryption ?? null);
            Config::set('mail.mailers.smtp.username', $settings->username ?? null);
            Config::set('mail.mailers.smtp.password', $settings->password ?? null);
            if ($settings->from_address) Config::set('mail.from.address', $settings->from_address);
            if ($settings->from_name) Config::set('mail.from.name', $settings->from_name);
        }

        Mail::to($this->recipient->contact->email)->send(new CampaignMail($this->campaign, $this->recipient));

        $this->recipient->update([
            'sent_at' => now(),
        ]);
    }
}
