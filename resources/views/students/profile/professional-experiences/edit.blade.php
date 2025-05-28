@extends('layouts.app')

@section('title', 'Modifier une expérience professionnelle')

@section('content')
    <section class="container">
        <h2 class="mb-4">Modifier une expérience professionnelle</h2>

        <x-professional-experience.form :professional-experience="$professionalExperience" />
    </section>
@endsection
