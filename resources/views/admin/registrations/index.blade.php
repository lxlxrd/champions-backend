@extends('layouts.app')

@section('title', 'Registrations List')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Registrations</h1>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full table-auto divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Season</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th> --}}
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($registrations as $registration)
            <tr class="hover:bg-gray-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->player?->first_name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->parent?->first_name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->season?->year ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->age_category?->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize">
                    <span class="px-2 py-1 rounded text-white {{ 
                        $registration->status === 'approved' ? 'bg-green-500' : (
                            $registration->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500'
                        )
                    }}">
                        {{ $registration->status }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($registration->date)->format('d/m/Y') }}</td>
                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->admin->name ?? '-' }}</td> --}}
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    @if($registration->status === 'pending')
                    <form method="POST" action="{{ route('admin.registrations.approve', $registration->id) }}" class="inline">
                        @csrf
                        <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.registrations.reject', $registration->id) }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                    </form>
                    @else
                    <span class="text-gray-400 italic">No actions</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-gray-500">No registrations found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
