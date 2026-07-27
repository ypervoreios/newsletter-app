<!DOCTYPE html>

<html>

<body>

@if($unsubscribeUrl)
<div style="margin-bottom:16px;padding:10px 12px;border:1px solid #e5e7eb;background:#f9fafb;border-radius:6px;font-size:12px;color:#4b5563;line-height:1.5;">
    If you no longer wish to receive these emails, you can <a href="{{ $unsubscribeUrl }}" style="color:#2563eb;text-decoration:underline;">unsubscribe here</a>.
</div>
@endif

<div>
{!! $campaign->content !!}
</div>

@if($recipient)
<img src="{{ route('campaigns.track.open', $recipient->token) }}" width="1" height="1" alt="" style="width:1px;height:1px;border:0;opacity:0;" />
@endif

</body>

</html>
