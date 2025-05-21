@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="max-width: 450px; width: 100%;">
            <h2 class="mb-4 text-center">Créer un compte entreprise</h2>

            <form action="{{ route('companies.register.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="company_name" class="form-label">Nom de l'entreprise</label>
                    <input type="text" class="form-control" name="company_name" autocomplete="company_name" placeholder="Exemple: Amazon" value="{{ old('company_name') }}">
                    @error('company_name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" autocomplete="email" placeholder="nom@exemple.com" value="{{ old('email') }}">
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" name="message" id="message" rows="3"
                        placeholder="Exemple: Nous recherchons des alternants pour la rentée...">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="gdpr_consent" value="true" {{ old('gdpr_consent') == 'true' ? 'checked' : '' }}>
                        J’accepte que mes données soient traitées dans le cadre de la gestion des candidatures.
                    </label>
                    @error('gdpr_consent')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Créer mon compte</button>
                </div>
            </form>

            <hr>

            <p class="text-center mb-0">
                Vous avez déjà un compte ?
                <a href="{{ route('login') }}">Se connecter</a>
            </p>

            <p class="text-center mb-0">
                Vous êtes une entreprise ?
                <a href="{{ route('login') }}">Faire une demande</a>
            </p>
        </div>
    </div>
@endsection
