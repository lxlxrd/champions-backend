@extends('layouts.app')

@section('title', 'Player Details')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Player Details</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        {{-- Parent Information --}}
        <div>
            <p class="font-semibold text-gray-700">Parent Last Name:</p>
            <p class="text-gray-900">{{ $player->parent->last_name ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-700">Parent First Name:</p>
            <p class="text-gray-900">{{ $player->parent->first_name ?? '-' }}</p>
        </div>

        {{-- Player Information --}}
        <div>
            <p class="font-semibold text-gray-700">Player Last Name:</p>
            <p class="text-gray-900">{{ $player->last_name }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-700">Player First Name:</p>
            <p class="text-gray-900">{{ $player->first_name }}</p>
        </div>

        <div>
            <p class="font-semibold text-gray-700">Birth Date:</p>
            <p class="text-gray-900">{{ $player->birth_date->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-700">Gender:</p>
            <p class="text-gray-900 capitalize">{{ $player->gender }}</p>
        </div>

        <div>
            <p class="font-semibold text-gray-700">Preferred Location:</p>
            <p class="text-gray-900 capitalize">{{ $player->preferred_location }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-700">Jersey Size:</p>
            <p class="text-gray-900">{{ $player->jersey_size }}</p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-8 flex justify-end space-x-4">
        <x-nav-link href="{{ route('admin.player.index') }}" icon="arrow-left" iconPosition="left" class="bg-gray-200 text-gray-800 hover:bg-gray-300">
            Back
        </x-nav-link>
        <x-nav-link href="{{ route('admin.players.edit', $player) }}" icon="edit" iconPosition="left" class="bg-blue-600 text-white hover:bg-blue-700">
            Edit
        </x-nav-link>
    </div>
</div>
@endsection
