@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Edit Post</h1>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div>
            <label for="title" class="block font-medium text-gray-700">Title</label>
            <input
                type="text"
                name="title"
                id="title"
                value="{{ old('title', $post->title) }}"
                class="w-full border border-gray-600 rounded mt-1"
                required
            >
            @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Type --}}
        <div>
            <label for="type" class="block font-medium text-gray-700">Type</label>
            <select
                name="type"
                id="type"
                class="w-full border border-gray-600 rounded mt-1"
                required
            >
                <option value="">-- Select --</option>
                <option value="GALLERY" {{ old('type', $post->type) === 'GALLERY' ? 'selected' : '' }}>Galery</option>
                <option value="PUB" {{ old('type', $post->type) === 'PUB' ? 'selected' : '' }}>Publication</option>
            </select>
            @error('type')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Contenu --}}
        <div>
            <label for="content" class="block font-medium text-gray-700">Content (optional)</label>
            <textarea
                name="content"
                id="content"
                rows="4"
                class="w-full border border-gray-600 rounded mt-1"
            >{{ old('content', $post->content) }}</textarea>
            @error('content')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Image actuelle --}}
        @if($post->image)
            <div>
                <label class="block font-medium text-gray-700 mb-1">Current image</label>
                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    alt="Image du post"
                    class="h-32 w-auto object-cover rounded mb-4"
                >
            </div>
        @endif

        {{-- Remplacement d’image --}}
        <div>
            <label for="image" class="block font-medium text-gray-700">Replace image (optional)</label>
            <input
                type="file"
                name="image"
                id="image"
                class="w-full border border-gray-600 rounded mt-1"
                accept="image/*"
            >
            @error('image')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Saison --}}
        <div>
            <label for="season" class="block font-medium text-gray-700">Season of post</label>
            <select
                name="season"
                id="season"
                class="w-full border border-gray-600 rounded mt-1"
            >
                <option value="">-- No  Season --</option>
                @foreach($seasons as $season)
                    <option
                        value="{{ $season->id }}"
                        {{ old('season', $post->seasons->first()->id ?? '') == $season->id ? 'selected' : '' }}
                    >
                        {{ $season->year }}
                    </option>
                @endforeach
            </select>
            @error('season')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex justify-end space-x-2">
            <a
                href="{{ route('admin.posts.index') }}"
                class="text-gray-600 hover:underline px-4 py-2"
            >Cancel</a>
            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
            >Update</button>
        </div>
    </form>
</div>
@endsection
