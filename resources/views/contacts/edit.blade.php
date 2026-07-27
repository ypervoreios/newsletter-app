@extends('layouts.admin')

@section('title')
Edit Contact
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Edit Contact</h1>
            <p class="text-sm text-gray-500">Update the contact details below.</p>
        </div>
        <a href="{{ route('contacts.index') }}" class="inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
            Back to list
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contacts.update', $contact) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Name</span>
            <input type="text" name="name" value="{{ old('name', $contact->name) }}" class="mt-2 w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="Contact name">
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Email</span>
            <input type="email" name="email" value="{{ old('email', $contact->email) }}" class="mt-2 w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="contact@example.com" required>
        </label>

        <label class="flex items-center gap-3 rounded border border-gray-300 px-4 py-3">
            <input type="checkbox" name="subscribed" value="1" {{ old('subscribed', $contact->subscribed) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
            <span class="text-sm font-medium text-gray-700">Subscribed</span>
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex items-center justify-center rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition">
                Save changes
            </button>
            <a href="{{ route('contacts.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</div>
@endsection