@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + New Post
        </a>
    </div>

    {{-- Filtre par saison --}}
    <form method="GET" action="{{ route('admin.posts.index') }}" class="mb-6 flex items-center space-x-4">
        <select name="season_id" class="border border-gray-600 rounded p-2">
            <option value="">-- All seasons --</option>
            @foreach($seasons as $season)
            <option value="{{ $season->id }}" {{ request('season_id') == $season->id ? 'selected' : '' }}>
                {{ $season->year }}
            </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>

        <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-600 hover:underline">Cancel Filter</a>
    </form>

    {{-- Message de succès --}}
    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- Liste des posts --}}
    @if($posts->isEmpty())
    <p class="text-gray-600">No post available.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded table-auto divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Type</th>
                    <th class="px-4 py-2 text-left">Contenu</th>
                    <th class="px-4 py-2 text-left">Image</th>
                    <th class="px-4 py-2 text-left">Season</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($posts as $post)
                <tr>
                    <td class="px-4 py-2 font-medium text-gray-900">{{ $post->title }}</td>
                    <td class="px-4 py-2">{{ $post->type }}</td>
                    <td class="px-4 py-2">{{ Str::limit($post->content, 50) }}</td>
                    <td class="px-4 py-2">
                        @if($post->image_path)
                        {{-- <img src="{{ asset('storage/' . $post->image) }}" alt="image" class="h-16 w-16 object-cover rounded"> --}}

                        <a href="{{ asset('storage/' . $post->image_path) }}" target="_blank" class="text-blue-600 underline">
                            See file
                        </a>
                        @else
                        <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if ($post->seasons->isNotEmpty())
                        {{ $post->seasons->first()->year }}
                        @else
                        <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:underline">Edit</a>

                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->appends(['season_id' => request('season_id')])->links() }}
    </div>
    @endif
</div>
@endsection
