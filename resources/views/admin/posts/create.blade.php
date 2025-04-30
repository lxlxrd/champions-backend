@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Create new Post</h1>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Titre --}}
        <div>
            <label for="title" class="block font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border border-gray-600 rounded mt-1" required>
            @error('title')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Type --}}
        <div>
            <label for="type" class="block font-medium text-gray-700">Type</label>
            <select name="type" id="type" class="w-full border border-gray-600 rounded mt-1" required>
                <option value="">-- Select --</option>
                <option value="GALERY" {{ old('type') == 'GALERY' ? 'selected' : '' }}>Galery</option>
                <option value="PUBLICATION" {{ old('type') == 'PUBLICATION' ? 'selected' : '' }}>Publication</option>
            </select>
            @error('type')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Contenu --}}
        <div>
            <label for="content" class="block font-medium text-gray-700">Content (optional)</label>
            <textarea name="content" id="content" rows="4" class="w-full border border-gray-600 rounded mt-1">{{ old('content') }}</textarea>
            @error('content')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Image --}}
        <div>
            <label for="image" class="block font-medium text-gray-700">Image</label>
            <input type="file" name="image" id="image" class="w-full border border-gray-600 rounded mt-1" accept="image/*" required>
            @error('image')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Saison --}}
        {{-- <div>
            <label for="season" class="block font-medium text-gray-700">Season</label>
            <select name="season" id="season" class="w-full border border-gray-600 rounded mt-1">
                <option value="">-- No season available --</option>
                @foreach($seasons as $season)
                <option value="{{ $season->id }}" {{ old('season') == $season->id ? 'selected' : '' }}>
                    {{ $season->year }}
                </option>
                @endforeach
            </select>
            @error('season')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div> --}}

        {{-- Bouton --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Create
            </button>
        </div>
    </form>
</div>
@endsection
