@extends('layouts.admin')

@section('title')
Edit Campaign
@endsection

@section('content')
<style>
    .campaign-editor .ck-editor__editable {
        min-height: 520px;
    }
</style>

<form method="POST" action="{{ route('campaigns.update', $campaign) }}" class="campaign-editor">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div class="mb-6 rounded border border-red-300 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Παρακαλώ συμπληρώστε όλα τα υποχρεωτικά πεδία.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <input
        name="title"
        value="{{ old('title', $campaign->title) }}"
        placeholder="Campaign title"
        class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring"
        required>

    <br><br>

    <input
        name="subject"
        value="{{ old('subject', $campaign->subject) }}"
        placeholder="Email subject"
        class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring"
        required>

    <br><br>

    <textarea
        id="content"
        name="content"
        rows="20"
        class="w-full rounded border border-gray-300"
        required>{{ old('content', $campaign->content) }}</textarea>

    <br><br>

    <div class="flex items-center gap-3">
        <button type="submit" class="inline-flex items-center justify-center rounded bg-blue-600 px-5 py-2.5 font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Update campaign
        </button>

        <a href="{{ route('campaigns.preview', $campaign) }}" class="inline-flex items-center justify-center rounded border border-gray-300 bg-white px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Cancel
        </a>
    </div>
</form>
@endsection
