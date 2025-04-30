@extends('layouts.app')

@section('title', 'Saisons')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Seasons List</h1>

        <a href="{{ route('admin.seasons.archived') }}" class="text-gray-700 hover:underline">
            Archived Seasons
        </a>
        <a href="{{ route('admin.seasons.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            +Add season
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if($seasons->isEmpty())
    <p class="text-gray-500 text-center">No Season available.</p>
    @else

    <form method="GET" action="{{ route('admin.seasons.index') }}" class="mb-4">
        <label for="year" class="block mb-2 text-sm font-medium text-gray-700">Filter by Year</label>
        <div class="flex gap-2">
            <select name="year" id="year" class="border rounded px-3 py-2">
                <option value="">-- All Years --</option>
                @foreach($years as $year)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
        </div>
    </form>

    <table class="min-w-full table-auto divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Year</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Archived</th>
                <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{-- Pour chaque saison --}}
            @foreach($seasons as $season)
            {{-- ligne principale --}}
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $season->year }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    @if($season->active)
                    <span class="text-green-600 font-medium">Active</span>
                    @else
                    <span class="text-red-600 font-medium">Archived</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                    @if($season->active)
                    <form method="POST" action="{{ route('admin.seasons.archive', $season) }}" class="inline">
                        @csrf
                        <button type="submit" class="text-yellow-600 hover:text-yellow-900" onclick="return confirm('Archive this season?')">
                            Archive
                        </button>
                    </form>
                    @else
                    <span class="text-gray-500 italic">Already archived</span>
                    @endif
                </td>
            </tr>

            {{-- en-tête parent/player --}}
            <tr class="bg-gray-50">
                <td class="px-6 py-2 text-sm font-medium text-gray-700">Parent</td>
                <td class="px-6 py-2 text-sm font-medium text-gray-700">Player</td>
                <td></td>
            </tr>

            {{-- données d’inscriptions --}}
            @forelse($season->registrations as $reg)
            <tr>
                <td class="px-6 py-2 text-sm text-gray-900">
                    {{ $reg->parent->first_name ?? '–' }} {{ $reg->parent->last_name ?? '' }}
                </td>
                <td class="px-6 py-2 text-sm text-gray-900">
                    {{ $reg->player->first_name ?? '–' }} {{ $reg->player->last_name ?? '' }}
                </td>
                <td></td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-2 text-sm text-gray-500 italic">
                    No registrations
                </td>
            </tr>
            @endforelse
            @endforeach
        </tbody>
    </table>

    @endif
</div>
@endsection
