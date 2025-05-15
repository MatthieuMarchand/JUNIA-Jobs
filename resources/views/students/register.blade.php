@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h2 class="mb-4 text-center">Créer un compte</h2>

            <form action="{{ route('students.register.store') }}" method="POST" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email" required autocomplete="email" placeholder="name@example.com">
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" required autocomplete="new-password">
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmation mot de passe --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required
                           autocomplete="new-password">
                </div>

                {{-- RGPD --}}
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="gdpr_consent" id="gdpr_consent" required>
                    <label class="form-check-label" for="gdpr_consent">
                        J’accepte que mes données soient traitées dans le cadre de la gestion des candidatures.
                    </label>
                    @error('gdpr_consent')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Créer mon compte</button>
                </div>
            </form>

            <hr>

            <p class="text-center mb-0">
                Vous avez déjà un compte ?
                <a href="{{ route('login.index') }}">Se connecter</a>
            </p>
        </div>
    </div>
@endsection
