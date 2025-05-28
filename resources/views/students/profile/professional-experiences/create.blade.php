@extends('layouts.app')

@section('title', 'Ajouter une expérience professionnelle')

@section('content')
    <section class="container">
        <h2 class="mb-4">Ajouter une expérience professionnelle</h2>

        <x-professional-experience.form />
    </section>
@endsection
