@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <section class="container">
        <h2 class="mb-4 d-flex align-items-end gap-2">
            Mon profil
            <a href="{{ route('students.profile.edit') }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Modifier
            </a>
        </h2>

        <x-student-profile :student-profile="$studentProfile" />
    </section>
@endsection
