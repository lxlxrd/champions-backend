@extends('layouts.app')

@section('title', 'Edit Season')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit Season</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.seasons.update', $season->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- <div>
            <label for="name" class="block font-medium">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $season->name) }}" class="w-full border-gray-300 rounded mt-1" required>
        </div> --}}

        <div>
            <label for="year" class="block font-medium">Year</label>
            <input type="number" name="year" id="year" value="{{ old('year', $season->year) }}" class="w-full border border-gray-600 rounded mt-1" required>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.seasons.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
