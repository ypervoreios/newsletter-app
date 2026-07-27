@extends('layouts.admin')

@section('title')
Send Newsletter
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-4xl">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Send "{{ $campaign->title }}"</h1>
            <p class="text-sm text-gray-500">Select the contacts you want to send this campaign to.</p>
        </div>
        <a href="{{ route('campaigns.index') }}" class="inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
            Back to campaigns
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <strong class="font-semibold">Please select at least one contact.</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('campaigns.send.submit', $campaign) }}" method="POST" class="space-y-6">
        @csrf

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-semibold text-gray-900">Subscribed Contacts</p>
                    <p class="text-sm text-gray-500">{{ $contacts->count() }} contacts available</p>
                </div>
                <p class="text-sm text-gray-500">Choose one or more contacts before sending.</p>
            </div>

            @if ($contacts->isEmpty())
                <div class="rounded-lg border border-dashed border-gray-300 bg-white p-6 text-center text-gray-500">
                    There are no subscribed contacts yet.
                </div>
            @else
                <div class="mb-4 flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-4">
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input id="select-all-contacts" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                        Select all contacts
                    </label>
                    <span id="selected-count" class="text-sm text-gray-500">{{ count(old('contacts', [])) }} selected</span>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($contacts as $contact)
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 transition hover:border-blue-500 focus-within:border-blue-500">
                            <input type="checkbox" name="contacts[]" value="{{ $contact->id }}" class="contact-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                {{ in_array($contact->id, old('contacts', [])) ? 'checked' : '' }} />
                            <div>
                                <div class="font-medium text-gray-900">{{ $contact->name ?? $contact->email }}</div>
                                <div class="text-sm text-gray-500">{{ $contact->email }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <button type="submit" class="inline-flex items-center justify-center rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition">
                Queue newsletter
            </button>
            <p class="text-sm text-gray-500">The campaign will be queued for the selected contacts.</p>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all-contacts');
        const checkboxes = Array.from(document.querySelectorAll('.contact-checkbox'));
        const selectedCount = document.getElementById('selected-count');

        function updateSelectedCount() {
            const count = checkboxes.filter(cb => cb.checked).length;
            selectedCount.textContent = `${count} selected`;
            selectAll.checked = count > 0 && count === checkboxes.length;
        }

        if (!selectAll || !selectedCount) return;

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateSelectedCount();
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        updateSelectedCount();
    });
</script>
@endpush
@endsection