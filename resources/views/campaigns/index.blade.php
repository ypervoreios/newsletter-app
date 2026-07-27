@extends('layouts.admin')


@section('title')
Campaigns
@endsection


@section('content')

<div class="bg-white shadow rounded-lg p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">Campaigns</h2>
            <p class="text-sm text-gray-500">Manage your newsletters and send test or live campaigns.</p>
        </div>

        <a href="{{ route('campaigns.create') }}"
           class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
            New Campaign
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
            <tr>
                <th class="p-3 font-medium text-gray-600">Title</th>
                <th class="p-3 font-medium text-gray-600">Subject</th>
                <th class="p-3 font-medium text-gray-600">Status</th>
                <th class="p-3 font-medium text-gray-600">Opens</th>
                <th class="p-3 font-medium text-gray-600">Sent at</th>
                <th class="p-3 font-medium text-gray-600">Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach($campaigns as $campaign)
                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                    <td class="p-3 text-gray-800">{{ $campaign->title }}</td>
                    <td class="p-3 text-gray-600">{{ $campaign->subject }}</td>
                    <td class="p-3 text-gray-600">{{ ucfirst($campaign->status) }}</td>
                    <td class="p-3 text-gray-600">
                        @php
                            $openRate = $campaign->recipients_count > 0
                                ? round(($campaign->opened_count / $campaign->recipients_count) * 100)
                                : 0;
                            $sentAt = $campaign->recipients_max_sent_at
                                ? \Illuminate\Support\Carbon::parse($campaign->recipients_max_sent_at)
                                : null;
                        @endphp

                        <div class="font-medium text-gray-800">{{ $campaign->opened_count }} / {{ $campaign->recipients_count }}</div>
                        <div class="text-xs text-gray-500">{{ $openRate }}% open rate</div>
                    </td>
                    <td class="p-3 text-gray-600">
                        {{ $sentAt ? $sentAt->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="p-3 space-y-2">
                        <div class="flex flex-wrap gap-2">
                            <a  class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition" href="{{ route('campaigns.preview', $campaign->id) }}">
                                Preview
                            </a>
                            <a class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition" href="{{ route('campaigns.test', $campaign->id) }}"
                               class="text-blue-600 hover:text-blue-800">Send Test</a>
                            <a class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition" href="{{ route('campaigns.send', $campaign->id) }}"
                                    class="text-blue-600 hover:text-blue-800">Send Newsletter</a>
                        </div>
                        <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
