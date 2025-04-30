@extends('layouts.app')

@section('title', 'Edit Age Category')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-semibold mb-6">Edit Age Category</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.age-categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div class="mb-4">
            <label for="min_age" class="block font-medium text-sm text-gray-700">Minimum Age</label>
            <input type="number" name="min_age" id="min_age" value="{{ old('min_age', $category->min_age) }}" 
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div class="mb-4">
            <label for="max_age" class="block font-medium text-sm text-gray-700">Maximum Age</label>
            <input type="number" name="max_age" id="max_age" value="{{ old('max_age', $category->max_age) }}" 
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        {{-- <div class="mb-6">
            <label for="admin_id" class="block font-medium text-sm text-gray-700">Admin</label>
            <select name="admin_id" id="admin_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" 
                        {{ $admin->id == $category->admin_id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div> --}}

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.age-categories.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
