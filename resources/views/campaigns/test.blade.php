@extends('layouts.admin')

@section('title')
Send Test Email
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Send Test Email</h1>
        <p class="text-sm text-gray-500">Campaign: <span class="font-medium text-gray-700">{{ $campaign->title }}</span></p>
    </div>

    <form method="POST" action="{{ route('campaigns.test.send', $campaign->id) }}" class="space-y-5">
        @csrf

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Recipient email</span>
            <input type="email" name="email" placeholder="test@email.com"
                   class="mt-2 w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex items-center justify-center rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition">
                Send Test
            </button>
            <a href="{{ route('campaigns.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to campaigns</a>
        </div>
    </form>
</div>
@endsection