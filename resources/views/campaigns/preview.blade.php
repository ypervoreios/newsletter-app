@extends('layouts.admin')

@section('title')
{{ $campaign->title }}
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">{{ $campaign->title }}</h2>
            <p class="text-sm text-gray-500">{{ $campaign->subject }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('campaigns.edit', $campaign) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Edit campaign
            </a>
            <a href="{{ route('campaigns.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">
                Back to campaigns
            </a>
        </div>
    </div>

    @php
        $openRate = $campaign->recipients_count > 0
            ? round(($campaign->opened_count / $campaign->recipients_count) * 100)
            : 0;
        $sentAt = $campaign->recipients_max_sent_at
            ? \Illuminate\Support\Carbon::parse($campaign->recipients_max_sent_at)
            : null;
    @endphp

    <div class="mb-6 grid gap-4 sm:grid-cols-4">
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <p class="text-sm text-gray-500">Recipients</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $campaign->recipients_count }}</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <p class="text-sm text-gray-500">Opened</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $campaign->opened_count }}</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <p class="text-sm text-gray-500">Open rate</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $openRate }}%</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <p class="text-sm text-gray-500">Sent at</p>
            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $sentAt ? $sentAt->format('d/m/Y H:i') : '-' }}</p>
        </div>
    </div>

    <div class="prose max-w-none text-gray-800">
        {!! $campaign->content !!}
    </div>
</div>
@endsection
