<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- En-tête du dashboard avec message de bienvenue --}}
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-lg text-gray-600">Welcome, {{ Auth::user()->name }}!</p>
    </div>

    {{-- Grille de statistiques clés --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total des posts publiés --}}
        <div class="bg-white p-6 rounded shadow flex flex-col">
            <h2 class="text-sm font-medium text-gray-500 uppercase mb-2">Post count</h2>
            <p class="text-3xl font-semibold text-gray-900">{{ $totalPosts }}</p>
        </div>

        {{-- Total des saisons actives --}}
        <div class="bg-white p-6 rounded shadow flex flex-col">
            <h2 class="text-sm font-medium text-gray-500 uppercase mb-2">Active season</h2>
            <p class="text-3xl font-semibold text-gray-900">{{ $activeSeasons }}</p>
        </div>

        {{-- Inscriptions en attente --}}
        <div class="bg-white p-6 rounded shadow flex flex-col">
            <h2 class="text-sm font-medium text-gray-500 uppercase mb-2">Pending registrations</h2>
            <p class="text-3xl font-semibold text-gray-900">{{ $pendingRegistrations }}</p>
        </div>

        {{-- Utilisateurs administrateurs --}}
        <div class="bg-white p-6 rounded shadow flex flex-col">
            <h2 class="text-sm font-medium text-gray-500 uppercase mb-2">Admin Registered</h2>
            <p class="text-3xl font-semibold text-gray-900">{{ $totalAdmins }}</p>
        </div>

        {{-- Section Publications --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-4">Publications</h2>
            @if($publicationPosts->isEmpty())
            <p class="text-gray-500">No publications.</p>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach($publicationPosts as $post)
                <div class="relative overflow-hidden rounded-lg shadow">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-32 object-cover">
                    <div class="p-2 bg-white">
                        <p class="text-sm font-semibold text-gray-800">{{ Str::limit($post->title, 40) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Section Galerie --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-4">Galery</h2>
            @if($galleryPosts->isEmpty())
            <p class="text-gray-500">No galery photo.</p>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach($galleryPosts as $post)
                <div class="relative overflow-hidden rounded-lg shadow">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-32 object-cover">
                    <div class="p-2 bg-white">
                        <p class="text-sm font-semibold text-gray-800">{{ Str::limit($post->title, 40) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Section rapide d'actions --}}
    <div class="mt-10 grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.posts.index') }}" class="block bg-blue-600 text-white p-4 rounded shadow hover:bg-blue-700">
            Manage Posts
        </a>
        <a href="{{ route('admin.seasons.index') }}" class="block bg-green-600 text-white p-4 rounded shadow hover:bg-green-700">
            Manage Seasons </a>
        <a href="{{ route('admin.registrations.index') }}" class="block bg-yellow-600 text-white p-4 rounded shadow hover:bg-yellow-700">
            Manage Registration</a>

        <a href="{{ route('admin.age-categories.index') }}" class="block bg-purple-600 text-white p-4 rounded shadow hover:bg-purple-700">
            Manage Categories
        </a>
    </div>
</div>
@endsection
