
@extends('layouts.admin')

@section('title')
Unsubscribed
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-3">You have been unsubscribed</h2>

        @if($recipient && $recipient->campaign)
            <p class="text-sm text-gray-700">You have been removed from the mailing list for the campaign: <strong>{{ $recipient->campaign->title }}</strong>.</p>
        @else
            <p class="text-sm text-gray-700">You have been removed from the mailing list.</p>
        @endif

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-white">Return</a>
        </div>
    </div>
@endsection
