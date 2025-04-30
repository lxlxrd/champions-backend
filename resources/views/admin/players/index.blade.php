@extends('layouts.app')

@section('title', 'Players List')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Players</h1>
    <x-nav-link href="{{ route('admin.players.create') }}" icon="user-plus" iconPosition="left" class="bg-green-600 hover:bg-green-700">
        Add Player
    </x-nav-link>
</div>

{{-- Message de succes --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded mb-4">
    {{ session('success') }}
</div>
@endif
<div class="overflow-x-auto">
    <table class="min-w-full table-auto divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Birth Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preferred Location</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jersey Size</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200">
            {{-- @foreach($players as $player) --}}
            @forelse($players as $player)
            <tr class="hover:bg-gray-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $player->parent->last_name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $player->first_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $player->last_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $player->birth_date->format('d/m/Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize">{{ $player->gender }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize">{{ $player->preferred_location }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $player->jersey_size }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <x-nav-link href="{{ route('admin.players.show', $player) }}" icon="eye" iconPosition="left" class="bg-blue-600 hover:bg-blue-700">
                        Show
                    </x-nav-link>
                </td>
            </tr>
            {{-- @endforeach --}}
            @empty
            <tr>
                <td colspan="8" class="text-center px-6 py-4 text-gray-500">
                    No player registered.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
