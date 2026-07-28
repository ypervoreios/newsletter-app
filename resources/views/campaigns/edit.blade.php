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

    <input
        name="title"
        value="{{ old('title', $campaign->title) }}"
        placeholder="Campaign title"
        class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring">

    <br><br>

    <input
        name="subject"
        value="{{ old('subject', $campaign->subject) }}"
        placeholder="Email subject"
        class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring">

    <br><br>

    <textarea
        id="content"
        name="content"
        rows="20"
        class="w-full rounded border border-gray-300">{{ old('content', $campaign->content) }}</textarea>

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
