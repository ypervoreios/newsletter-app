@extends('layouts.admin')

@section('title')
Import Contacts
@endsection

@section('content')

<div class="max-w-2xl rounded-lg bg-white p-6 shadow">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Import Contacts</h2>
        <p class="mt-1 text-sm text-gray-500">Upload a CSV file with contact name and email columns.</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('contacts.import.store') }}"
        enctype="multipart/form-data"
        class="space-y-5">
        @csrf

        <div>
            <label for="file" class="mb-1 block text-sm font-medium text-gray-700">CSV file</label>
            <input
                id="file"
                type="file"
                name="file"
                accept=".csv,.txt"
                required
                class="block w-full rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 file:mr-4 file:rounded file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-medium file:text-blue-700 hover:file:bg-blue-100 focus:border-blue-500 focus:outline-none focus:ring">
            <p class="mt-2 text-sm text-gray-500">First row should be headers. Each row should contain name, then email.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex items-center justify-center rounded bg-blue-600 px-5 py-2.5 font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Import
            </button>

            <a href="{{ route('contacts.index') }}" class="inline-flex items-center justify-center rounded border border-gray-300 bg-white px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
