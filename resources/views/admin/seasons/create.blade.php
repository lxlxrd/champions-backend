@extends('layouts.app')

@section('title', 'Create Season')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-semibold mb-4">Create New Season</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.seasons.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="year" class="block font-medium">Year</label>
            <input type="number" name="year" id="year" value="{{ old('year') }}" class="w-full border border-gray-600 rounded mt-1" required>
        </div>

        {{-- Si une saison active existe déjà, on l’affiche ici --}}
        @if($activeExists)
        <div id="active-warning" class="bg-yellow-100 text-yellow-800 p-3 rounded">
            Season already activated, check this will deactivate the current active season.
        </div>
        @endif

        <div class="flex items-center">
            <input type="checkbox" name="active" id="active" class="mr-2" value="1" {{ old('active') ? 'checked' : '' }}>
            <label for="active" class="text-sm">Active</label>
        </div>


        <script>
            const checkbox = document.getElementById('active');
            const warning = document.getElementById('active-warning');

            function toggleWarning() {
                if (checkbox.checked) {
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            }

            checkbox.addEventListener('change', toggleWarning);
            window.addEventListener('load', toggleWarning); // pour prendre en compte old('active')

        </script>


        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.seasons.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
        </div>
    </form>
</div>
@endsection
