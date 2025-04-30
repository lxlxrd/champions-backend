@extends('layouts.app')

@section('title', 'Create Age Category')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Create Age Category</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.age-categories.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-600 rounded mt-1" required>
        </div>

        <div>
            <label for="min_age" class="block font-medium">Minimum Age</label>
            <input type="number" name="min_age" id="min_age" value="{{ old('min_age') }}" class="w-full border border-gray-600 rounded mt-1" required>
        </div>

        <div>
            <label for="max_age" class="block font-medium">Maximum Age</label>
            <input type="number" name="max_age" id="max_age" value="{{ old('max_age') }}" class="w-full border border-gray-600 rounded mt-1" required>
        </div>


        <div class="flex justify-end">
            <a href="{{ route('admin.age-categories.index') }}" class="text-gray-600 hover:underline mr-4">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>
    </form>
</div>
@endsection
