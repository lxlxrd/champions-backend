<!DOCTYPE html>
<html lang="fr">

<head>
    @include('layouts.partials.head')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    @include('layouts.partials.nav')
    <main class="container mx-auto mt-8 px-4">
        {{-- Messages flash --}}
        @if (session('success'))
            <div class="d-flex justify-content-center">
                <x-alert type="success" :message="session('success')" />
            </div>
        @endif

        @yield('content')
    </main>

</body>

</html>
