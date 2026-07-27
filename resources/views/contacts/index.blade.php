@extends('layouts.admin')


@section('title')
Contacts
@endsection



@section('content')


<div class="bg-white shadow rounded-lg p-6">


<div class="flex justify-between mb-5">


<h2 class="text-xl font-bold">
Contact List
</h2>


<div class="flex items-center gap-3">
    <a href="{{ route('contacts.create') }}"
    class="inline-flex items-center justify-center rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 transition">
        Create
    </a>

    <a href="{{ route('contacts.import') }}"
    class="inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 font-medium text-gray-700 hover:bg-gray-50 transition">
        Import CSV
    </a>
</div>


</div>




<table class="w-full">


<thead class="border-b">


<tr>

<th class="text-left p-3">
Name
</th>
                <th class="text-left p-3">
Email
</th>
                <th class="text-left p-3">
Subscription
</th>
                <th class="text-left p-3">
Created
</th>
                <th class="text-left p-3">
</th>


</tr>


</thead>



<tbody>


@foreach($contacts as $contact)


<tr class="border-b">


                    <td class="p-3">
                        {{ $contact->name ?? '-' }}
                    </td>
                    <td class="p-3">
                        {{ $contact->email }}
                    </td>
                    <td class="p-3">
                        @if($contact->subscribed)
                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">Subscribed</span>
                        @else
                            <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">Unsubscribed</span>
                        @endif
                    </td>
                    <td class="p-3">
                        {{ $contact->created_at->format('d/m/Y') }}
                    </td>
                    <td class="p-3 flex flex-wrap gap-2 items-center">
                        <a href="{{ route('contacts.edit', $contact) }}" class="inline-flex items-center justify-center rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('contacts.destroy',$contact) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Delete
                            </button>
                        </form>
                    </td>


</tr>


@endforeach


</tbody>


</table>



<div class="mt-5">

{{ $contacts->links() }}

</div>


</div>



@endsection
