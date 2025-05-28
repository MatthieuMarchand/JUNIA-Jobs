@extends('layouts.app')

@section('title', 'Modifier une formation')

@section('content')
    <section class="container">
        <h2 class="mb-4">Modifier une formation</h2>

        <x-academic-record.form :academic-record="$academicRecord" />
    </section>
@endsection
