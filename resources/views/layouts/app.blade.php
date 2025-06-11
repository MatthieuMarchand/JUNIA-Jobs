<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href={{ asset('images/favicon.png') }} type="image/png" />

    <title>
        @hasSection('title')
            @yield('title') | JUNIA Jobs
        @else
            JUNIA Jobs
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="min-vh-100">
        @include('components.header')

        {{-- @if(Breadcrumbs::exists())
            <div class="container">
                {{ Breadcrumbs::render() }}
            </div>
        @endif --}}

        @yield('content')
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @session('success')
        <x-toast type="success">
            {{ $value }}
        </x-toast>
        @endsession

        @session('error')
        <x-toast type="error">
            {{ $value }}
        </x-toast>
        @endsession

        @session('info')
        <x-toast type="info">
            {{ $value }}
        </x-toast>
        @endsession

        @session('warning')
        <x-toast type="warning">
            {{ $value }}
        </x-toast>
        @endsession
    </div>

    <footer>
        <ul>
            <li><a href="{{ route('legal.index') }}">Mentions légales</a></li>
            <li><a href="{{ route('legal.gdpr') }}">Politique RGPD</a></li>
            <li><a href="{{ route('legal.conditions-of-use') }}">Conditions d'utilisation</a></li>
        </ul>

        <a href="{{  route('home') }}">
            <img src="{{ asset('images/logos/junia_jobs.svg') }}" alt="Logo JUNIA Jobs">
        </a>
    </footer>
</body>
</html>
