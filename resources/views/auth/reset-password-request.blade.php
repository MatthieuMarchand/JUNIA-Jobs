@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="max-width: 450px; width: 100%;">
            <h2 class="mb-4 text-center">Réinitialiser votre mot de passe</h2>

            <form action="{{ route('password-reset.request.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Votre adresse email</label>
                    <input type="email" class="form-control" name="email" required autocomplete="email" placeholder="name@example.com"
                           value="{{ old('email') }}">
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Recevoir l'email de réinitialisation</button>
                </div>
            </form>
        </div>
    </div>
@endsection
