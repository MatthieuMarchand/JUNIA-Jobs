@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="max-width: 450px; width: 100%;">
            <h2 class="mb-4 text-center">Connexion</h2>

            <form action="{{ route('login.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" required autocomplete="email" placeholder="nom@exemple.com"
                           value="{{ old('email') }}">
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" required autocomplete="current-password"
                           value="{{ old('password') }}">
                    <small class="mb-0">
                        <a href="{{ route('password-reset.request.create') }}">Mot de passe oublié ?</a>
                    </small>
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

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
