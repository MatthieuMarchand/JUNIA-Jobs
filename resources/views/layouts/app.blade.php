<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    @if(Breadcrumbs::exists())
        <div class="container">
            {{ Breadcrumbs::render() }}
        </div>
    @endif

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

<div class="container">
    <footer class="py-5">
        <div class="row">
            <div class="col-6 col-md-2 mb-3"><h5>Légal</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="{{ route('legal.index') }}" class="nav-link p-0 text-body-secondary">Mentions légales</a></li>
                    <li class="nav-item mb-2"><a href="{{ route('legal.gdpr') }}" class="nav-link p-0 text-body-secondary">RGPD</a></li>
                    <li class="nav-item mb-2"><a href="{{ route('legal.conditions-of-use') }}" class="nav-link p-0 text-body-secondary">Conditions
                            d'utilisation</a></li>
                </ul>
            </div>

        </div>
        <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
            <p>© {{ now()->year }} {{ config('app.name') }}. Tous droits réservés.</p>
        </div>
    </footer>
</div>

</body>
</html>
