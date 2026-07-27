@extends('layouts.admin')


@section('title')
Dashboard
@endsection



@section('content')


<div class="grid grid-cols-3 gap-6">


<div class="bg-white rounded-lg shadow p-6">

<h3 class="text-gray-500">
Contacts
</h3>


<p class="text-3xl font-bold">
{{ $contacts }}
</p>

</div>




<div class="bg-white rounded-lg shadow p-6">

<h3 class="text-gray-500">
Campaigns
</h3>


<p class="text-3xl font-bold">
{{ $campaigns }}
</p>

</div>



<div class="bg-white rounded-lg shadow p-6">

<h3 class="text-gray-500">
Sent campaigns
</h3>


<p class="text-3xl font-bold">
{{ $sentCampaigns }}
</p>

</div>



</div>

<div class="mt-8 bg-white rounded-lg shadow">
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Sent Campaigns</h2>
            <p class="text-sm text-gray-500">Campaigns that have already been queued for sending.</p>
        </div>

        <a href="{{ route('campaigns.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
            View all campaigns
        </a>
    </div>

    @if($latestSentCampaigns->isEmpty())
        <div class="px-6 py-8 text-sm text-gray-500">
            No sent campaigns yet.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Title</th>
                        <th class="px-6 py-3 font-semibold">Subject</th>
                        <th class="px-6 py-3 font-semibold">Opens</th>
                        <th class="px-6 py-3 font-semibold">Sent at</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($latestSentCampaigns as $campaign)
                        @php
                            $openRate = $campaign->recipients_count > 0
                                ? round(($campaign->opened_count / $campaign->recipients_count) * 100)
                                : 0;
                            $sentAt = $campaign->recipients_max_sent_at
                                ? \Illuminate\Support\Carbon::parse($campaign->recipients_max_sent_at)
                                : $campaign->updated_at;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $campaign->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $campaign->subject }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <div class="font-medium text-gray-800">{{ $campaign->opened_count }} / {{ $campaign->recipients_count }}</div>
                                <div class="text-xs text-gray-500">{{ $openRate }}% open rate</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $sentAt->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('campaigns.preview', $campaign) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                    Preview
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>


@endsection
