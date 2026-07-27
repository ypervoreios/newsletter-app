@extends('layouts.admin')

@section('title')
Mail settings
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Mail (SMTP) Settings</h1>
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Back</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('settings.mail.update') }}" class="space-y-4">
        @csrf

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Host</span>
            <input name="host" value="{{ old('host', $settings->host ?? '') }}" class="mt-1 block w-full rounded border border-gray-300 px-3 py-2" />
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Port</span>
            <input name="port" value="{{ old('port', $settings->port ?? '') }}" class="mt-1 block w-full rounded border border-gray-300 px-3 py-2" />
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Username</span>
            <input name="username" value="{{ old('username', $settings->username ?? '') }}" class="mt-1 block w-full rounded border border-gray-300 px-3 py-2" />
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Password</span>
            <input name="password" value="{{ old('password', $settings->password ?? '') }}" type="password" class="mt-1 block w-full rounded border border-gray-300 px-3 py-2" />
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Encryption (tls/ssl)</span>
            <input name="encryption" value="{{ old('encryption', $settings->encryption ?? '') }}" class="mt-1 block w-full rounded border border-gray-300 px-3 py-2" />
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">From address</span>
            <input name="from_address" value="{{ old('from_address', $settings->from_address ?? '') }}" class="mt-1 block w-full rounded border border-gray-300 px-3 py-2" />
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">From name</span>
            <input name="from_name" value="{{ old('from_name', $settings->from_name ?? '') }}" class="mt-1 block w-full rounded border border-gray-300 px-3 py-2" />
        </label>

        <div class="flex items-center gap-3">
            <button class="inline-flex items-center justify-center rounded bg-blue-600 px-4 py-2 text-white">Save</button>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</div>
@endsection
