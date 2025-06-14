<!DOCTYPE html>
<html lang="fr">
<head>
    @include('layouts.partials.head')
</head>
<body class="bg-gray-100">
    @include('layouts.partials.nav')
    <main class="container mx-auto mt-8 px-4">
        {{-- Messages flash --}}
        @if(session('success'))
        <x-alert type="success" :message="session('succes')" />
        @endif
        @yield('content')
    </main>
</body>

</html>
