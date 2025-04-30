<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }} | {{ $head_title ?? 'Blanck page' }}</title>
    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Agence Nationale de Gestion l'Environnement au Togo. ANGE">
    <meta name="keywords" content="Agence Nationale de Gestion l'Environnement au Togo, ANGE">
    <meta name="author" content="Agence Nationale de Gestion l'Environnement au Togo, ANGE">
    <link rel="icon" href="{{ asset('new/assets/images/logos/favicon.ico') }}" type="image/x-icon">
    <!-- [Font] Family -->
    @include('layouts.new.linkcss') 
    @include('layouts.new.scriptLinkHeader')
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast=""
    data-pc-theme="light">

    @include('layouts.new.navigation')
    @include('layouts.new.header')
    {{-- @include('layouts.new.announcement') --}}

    <div class="pc-container">
        <div class="pc-content">
            @include('layouts.new.breadCrumb')
            @yield('content')
        </div>
    </div>

    @include('layouts.new.footer')
    @include('layouts.new.deleteForm')
    @include('layouts.new.scriptLinkFooter')
</body>

</html>