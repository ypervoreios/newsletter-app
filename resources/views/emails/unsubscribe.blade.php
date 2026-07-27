<!DOCTYPE html>
<html>
<body>

<p>Hi {{ $contact->name ?? 'Subscriber' }},</p>

<p>You've been successfully unsubscribed from our mailing list. You will no longer receive campaign emails.</p>

@if($recipient && $recipient->campaign)
    <p>Campaign: <strong>{{ $recipient->campaign->title }}</strong></p>
@endif

<p>If this was a mistake, please contact us.</p>

</body>
</html>
