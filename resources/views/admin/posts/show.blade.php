@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    {{-- Boutons de navigation --}}
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:underline">&larr; Back to post list</a>
        <div class="flex space-x-2">
            <a href="{{ route('admin.posts.edit', $post) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure to  delete this post?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
            </form>
        </div>
    </div>

    {{-- Détail du post --}}
    <div class="bg-white p-6 rounded shadow space-y-4">
        <h1 class="text-3xl font-bold">{{ $post->title }}</h1>

        <div class="flex items-center space-x-4 text-sm text-gray-500">
            <span>Type : <strong>{{ ucfirst(strtolower($post->type)) }}</strong></span>
            @if($post->seasons->isNotEmpty())
                <span>Season: <strong>{{ $post->seasons->first()->year }}</strong></span>
                <span>Date of publication: <strong>{{ \Carbon\Carbon::parse($post->seasons->first()->pivot->date)->format('d/m/Y') }}</strong></span>
                <span>Post by : <strong>{{ optional($post->seasons->first()->pivot->admin)->name ?? '–' }}</strong></span>
            @else
                <span class="italic text-gray-400">No saison associated</span>
            @endif
        </div>

        @if($post->image)
            <div>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Illustration du post" class="w-full object-cover rounded">
            </div>
        @endif

        @if($post->content)
            <div class="prose">
                {!! nl2br(e($post->content)) !!}
            </div>
        @endif
    </div>
</div>
@endsection
