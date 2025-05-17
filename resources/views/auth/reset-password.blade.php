@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="max-width: 450px; width: 100%;">
            <h2 class="mb-4 text-center">Réinitialiser le mot de passe</h2>

            <form action="{{ route('password-reset.store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" required autocomplete="email" placeholder="name@example.com"
                           value="{{ old('email') }}">
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" name="password" required autocomplete="new_password" placeholder="name@example.com"
                           value="{{ old('password') }}">
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
@endsection
