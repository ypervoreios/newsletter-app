@extends('layouts.admin')

@section('title')
Create User
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Create User</h1>
            <p class="text-sm text-gray-500">Add a new user to the application.</p>
        </div>
        <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
            Back to users
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

    <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
        @csrf

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Name</span>
            <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded border border-gray-300 px-4 py-2" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Email</span>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded border border-gray-300 px-4 py-2" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Password</span>
            <input type="password" name="password" class="mt-2 w-full rounded border border-gray-300 px-4 py-2" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-gray-700">Confirm Password</span>
            <input type="password" name="password_confirmation" class="mt-2 w-full rounded border border-gray-300 px-4 py-2" required>
        </label>

        <label class="flex items-center gap-3 rounded border border-gray-300 px-4 py-3">
            <input type="checkbox" name="is_admin" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
            <span class="text-sm font-medium text-gray-700">Administrator</span>
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex items-center justify-center rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition">
                Create user
            </button>
            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</div>
@endsection
