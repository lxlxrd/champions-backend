@extends('layouts.app')

@section('title', 'Edit Player')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Player</h1>

    <form action="{{ route('admin.players.update', $player) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $player->first_name) }}" 
                       class="mt-1 block w-full rounded-md border border-gray-600 shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $player->last_name) }}" 
                       class="mt-1 block w-full rounded-md border border-gray-600 shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Birth Date</label>
                <input type="date" name="birth_date" value="{{ old('birth_date', $player->birth_date->format('Y-m-d')) }}" 
                       class="mt-1 block w-full rounded-md border border-gray-600 shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" class="mt-1 block w-full rounded-md border border-gray-600 shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="male" {{ old('gender', $player->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $player->gender) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Preferred Location</label>
                <input type="text" name="preferred_location" value="{{ old('preferred_location', $player->preferred_location) }}" 
                       class="mt-1 block w-full rounded-md border border-gray-600 shadow-sm focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jersey Size</label>
                <input type="text" name="jersey_size" value="{{ old('jersey_size', $player->jersey_size) }}" 
                       class="mt-1 block w-full rounded-md border border-gray-600 shadow-sm focus:ring focus:ring-blue-200">
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            <x-nav-link 
                href="{{ route('admin.players.index') }}" 
                icon="arrow-left" 
                iconPosition="left" 
                class="bg-gray-600 hover:bg-gray-700">
                Cancel
            </x-nav-link>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Save
            </button>
        </div>
    </form>
</div>
@endsection
