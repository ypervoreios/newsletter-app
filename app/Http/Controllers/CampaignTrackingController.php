<?php

namespace App\Http\Controllers;

use App\Models\CampaignRecipient;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\MailSetting;
use App\Mail\UnsubscribeConfirmationMail;

class CampaignTrackingController extends Controller
{
    public function open(string $token): Response
    {
        $recipient = CampaignRecipient::where('token', $token)->first();

        if ($recipient) {
            $recipient->forceFill([
                'opened_at' => $recipient->opened_at ?? now(),
                'opens_count' => $recipient->opens_count + 1,
            ])->save();
        }

        $pixel = base64_decode('R0lGODlhAQABAPAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==');

        return response($pixel, 200, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    public function unsubscribe(string $token)
    {
        $recipient = CampaignRecipient::where('token', $token)->first();

        if ($recipient) {
            $contact = $recipient->contact;
            if ($contact) {
                $contact->subscribed = false;
                $contact->save();
                // Apply DB mail settings before sending confirmation
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

                Mail::to($contact->email)->queue(new UnsubscribeConfirmationMail($contact, $recipient));
            }
        }

        return view('unsubscribe.confirm', compact('recipient'));
    }
}
