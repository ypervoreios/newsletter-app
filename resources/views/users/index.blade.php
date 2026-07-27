@extends('layouts.admin')

@section('title')
Users
@endsection

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold">Application Users</h2>
            <p class="text-sm text-gray-500">List of registered users in the application.</p>
        </div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 transition">
            Create user
        </a>
    </div>

    <table class="w-full">
        <thead class="border-b">
            <tr>
                <th class="text-left p-3">Name</th>
                <th class="text-left p-3">Email</th>
                <th class="text-left p-3">Verified</th>
                <th class="text-left p-3">Role</th>
                <th class="text-left p-3">Created</th>
                <th class="text-left p-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-b">
                    <td class="p-3">{{ $user->name ?? '-' }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">
                        @if($user->email_verified_at)
                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">Verified</span>
                        @else
                            <span class="inline-flex rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-700">Pending</span>
                        @endif
                    </td>
                    <td class="p-3">
                        @if($user->is_admin)
                            <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700">Administrator</span>
                        @else
                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">User</span>
                        @endif
                    </td>
                    <td class="p-3">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="p-3 flex flex-wrap gap-2 items-center">
                        <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
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
        {{ $users->links() }}
    </div>
</div>
@endsection
