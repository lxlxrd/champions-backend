@extends('layouts.app')

@section('title', 'Create Player')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-md shadow-md">
    <h1 class="text-2xl font-semibold mb-4">Create new Player</h1>

    {{-- 1) Message d'erreur si âge insuffisant --}}
    @if(session('error_min_age'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error_min_age') }}
    </div>
    @endif

    <form action="{{ route('admin.players.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- First Name --}}
        <div>
            <label for="first_name" class="block text-gray-700 font-medium mb-1">First Name</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="bg-gray-50 border border-gray-600 text-gray-900 text-sm rounded-lg 
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            @error('first_name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Last Name --}}
        <div>
            <label for="last_name" class="block text-gray-700 font-medium mb-1">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="bg-gray-50 border border-gray-600 text-gray-900 text-sm rounded-lg 
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            @error('last_name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Birth Date --}}
        <div>
            <label for="birth_date" class="block text-gray-700 font-medium mb-1">Birth Date</label>
            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" class="bg-gray-50 border border-gray-600 text-gray-900 text-sm rounded-lg 
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            @error('birth_date')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gender --}}
        <div>
            <span class="block text-gray-700 font-medium mb-1">Gender*</span>
            <div class="flex space-x-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="female" class="h-4 w-4 text-blue-600 border border-gray-600 focus:ring-blue-500" {{ old('gender') === 'female' ? 'checked' : '' }} required />
                    <span class="ml-2 text-gray-700">Female</span>
                </label>

                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="male" class="h-4 w-4 text-blue-600 border border-gray-600 focus:ring-blue-500" {{ old('gender') === 'male' ? 'checked' : '' }} />
                    <span class="ml-2 text-gray-700">Male</span>
                </label>

                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="other" class="h-4 w-4 text-blue-600 border border-gray-600 focus:ring-blue-500" {{ old('gender') === 'other' ? 'checked' : '' }} />
                    <span class="ml-2 text-gray-700">Other</span>
                </label>
            </div>
            @error('gender')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Preferred Location --}}
        <div>
            <span class="block text-gray-700 font-medium mb-1">Preferred Location*</span>
            <div class="flex space-x-6">
                @foreach(['Courtice', 'Bowmanville', 'Newcastle'] as $loc)
                <label class="inline-flex items-center">
                    <input type="radio" name="preferred_location" value="{{ strtolower($loc) }}" class="h-4 w-4 text-blue-600 border border-gray-600 focus:ring-blue-500" {{ old('preferred_location') === strtolower($loc) ? 'checked' : '' }} required />
                    <span class="ml-2 text-gray-700">{{ $loc }}</span>
                </label>
                @endforeach
            </div>
            @error('preferred_location')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jersey Size --}}
        <div>
            <span class="block text-gray-700 font-medium mb-1">Jersey Size*</span>
            <div class="flex space-x-6">
                @foreach(['YS', 'YM', 'YL'] as $size)
                <label class="inline-flex items-center">
                    <input type="radio" name="jersey_size" value="{{ $size }}" class="h-4 w-4 text-purple-600 border border-gray-600 focus:ring-purple-500" {{ old('jersey_size') === $size ? 'checked' : '' }} required />
                    <span class="ml-2 text-gray-700">{{ $size }}</span>
                </label>
                @endforeach
            </div>
            @error('jersey_size')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Create
            </button>
        </div>
    </form>
</div>
@endsection
