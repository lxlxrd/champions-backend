<nav class="bg-blue-600 text-white p-4">
    <div class="container mx-autp flex justify-between items-center">
        <a href="{{route('admin.home')}}" class="text-xl font-bold">Champions Manager
            <div class="space-x-4 flex items-center">
                {{-- Home → Dashboard Admin --}}
                <x-nav-link href="{{ route('admin.home') }}" :active="request()->routeIs('admin.home')">
                    Home
                </x-nav-link>
                <x-nav-link href="{{route('admin.player.index')}}" active="players.*"> players </x-nav-link>
            </div>
        </a>
    </div>
</nav>
