<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\MailSetting;
use App\Mail\CampaignMail;
use App\Jobs\SendNewsletterJob;
use App\Models\Contact;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $campaigns = Campaign::withCount([
             'recipients',
             'recipients as opened_count' => fn ($query) => $query->whereNotNull('opened_at'),
         ])
             ->withMax('recipients', 'sent_at')
             ->latest()
             ->get();

        return view(
            'campaigns.index',
            compact('campaigns')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([

            'title'=>'required',

            'subject'=>'required',

            'content'=>'required'

        ]);


        Campaign::create([

            'title'=>$request->title,

            'subject'=>$request->subject,

            'content'=>$request->content

        ]);


        return redirect('/campaigns');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'title' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ]);

        $campaign->update([
            'title' => $request->title,
            'subject' => $request->subject,
            'content' => $request->content,
        ]);

        return redirect()->route('campaigns.preview', $campaign)
            ->with('success', 'Campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect('/campaigns');
    }

    public function preview(Campaign $campaign)
{
    $campaign->loadCount([
        'recipients',
        'recipients as opened_count' => fn ($query) => $query->whereNotNull('opened_at'),
    ]);

    $campaign->loadMax('recipients', 'sent_at');

    return view(
        'campaigns.preview',
        compact('campaign')
    );
}

    public function testEmail(Campaign $campaign)
    {
        return view(
            'campaigns.test',
            compact('campaign')
        );
    }

    public function sendTestEmail(Request $request, Campaign $campaign)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Apply DB mail settings for the test send
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

        Mail::to($request->email)
            ->send(new CampaignMail($campaign));

        return redirect()->back()->with('success', 'Test email sent successfully.');
    }

    public function send(Campaign $campaign)
    {
        $contacts = Contact::where('subscribed', true)->get();

        return view(
            'campaigns.send',
            compact('campaign', 'contacts')
        );
    }

    public function sendToContacts(Request $request, Campaign $campaign)
    {
        $request->validate([
            'contacts' => 'required|array|min:1',
            'contacts.*' => 'exists:contacts,id',
        ]);

        $contacts = Contact::whereIn('id', $request->contacts)
            ->where('subscribed', true)
            ->get();

        if ($contacts->isEmpty()) {
            return back()->withErrors(['contacts' => 'No valid subscribed contacts selected.'])->withInput();
        }

        foreach ($contacts as $contact) {
            $recipient = $campaign->recipients()->updateOrCreate(
                ['contact_id' => $contact->id],
                [
                    'token' => Str::random(48),
                    'sent_at' => null,
                    'opened_at' => null,
                    'opens_count' => 0,
                ]
            );

            SendNewsletterJob::dispatch($campaign, $recipient);
        }

        $campaign->update(['status' => 'sent']);

        return redirect('/campaigns')
            ->with('success', 'Newsletter queued successfully.');
    }
}
