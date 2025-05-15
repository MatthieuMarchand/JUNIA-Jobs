@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h2 class="mb-4 text-center">Connexion</h2>

            <form action="{{ route('login.store') }}" method="POST" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email" required autocomplete="email" placeholder="name@example.com">
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" required autocomplete="current-password">
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>

            <hr>

            <p class="text-center mb-0">
                Pas encore de compte ?
                <a href="{{ route('students.register.index') }}">S'inscrire</a>
            </p>
        </div>
    </div>
@endsection
