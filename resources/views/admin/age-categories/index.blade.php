@extends('layouts.app')

@section('title', 'Age Categories')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Age Categories</h1>
        <a href="{{ route('admin.age-categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full table-auto divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Min Age</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Max Age</th>
                    {{-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Created By</th> --}}
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $category->min_age }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $category->max_age }}</td>
                        {{-- <td class="px-6 py-4 text-gray-800">{{ $category->admin->name ?? 'N/A' }}</td> --}}
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.age-categories.edit', $category->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.age-categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
