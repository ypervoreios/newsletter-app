@extends('layouts.admin')

@section('title')
Create Contact
@endsection

@section('content')

<div class="max-w-2xl rounded-lg bg-white p-6 shadow">
    <form method="POST" action="{{ route('contacts.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Name</label>
            <input
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contact name"
                required
                class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="contact@example.com"
                required
                class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex items-center justify-center rounded bg-blue-600 px-5 py-2.5 font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Save
            </button>

            <a href="{{ route('contacts.index') }}" class="inline-flex items-center justify-center rounded border border-gray-300 bg-white px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
