@extends('layouts.app')

@section('title', 'Archived Seasons')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Archived Seasons</h1>
        <a href="{{ route('admin.seasons.index') }}"
           class="text-blue-600 hover:underline">
            ← Back to all seasons
        </a>
    </div>

    @if($archived->isEmpty())
        <p class="text-gray-500 text-center">No archived seasons.</p>
    @else
        <table class="min-w-full table-auto divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Year</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Parents</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Players</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($archived as $season)
                <tr>
                    {{-- Year --}}
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $season->year }}</td>

                    {{-- Parents --}}
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($season->registrations->isEmpty())
                            <span class="text-gray-500 italic">No registrations</span>
                        @else
                            <ul class="list-none space-y-1">
                                @foreach($season->registrations as $reg)
                                    <li>{{ $reg->parent->first_name ?? '–' }} {{ $reg->parent->last_name ?? '' }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>

                    {{-- Players --}}
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($season->registrations->isEmpty())
                            <span class="text-gray-500 italic">No registrations</span>
                        @else
                            <ul class="list-none space-y-1">
                                @foreach($season->registrations as $reg)
                                    <li>{{ $reg->player->first_name ?? '–' }} {{ $reg->player->last_name ?? '' }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                        <a href="{{ route('admin.seasons.edit', $season) }}"
                           class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.seasons.destroy', $season) }}"
                              method="POST" class="inline" onsubmit="return confirm('Delete this season?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $archived->links() }}
        </div>
    @endif
</div>
@endsection
