@extends('layouts.base')

@section('base-content')
    @include('components.navbar')

    @if(Breadcrumbs::exists())
        <div class="container">
            {{ Breadcrumbs::render() }}
        </div>
    @endif

    @yield('content')
@endsection
