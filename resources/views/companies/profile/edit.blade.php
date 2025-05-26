@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h2 class="mb-4">Modifier votre profil entreprise</h2>

            <form action="{{ route('companies.profile.update') }}" method="POST" novalidate>
                @method("PATCH")
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'entreprise</label>
                    <input type="text" class="form-control" name="name" id="name"
                           value="{{ old('name', $companyProfile->name) }}"
                           placeholder="BeeToGreen" autocomplete="given-name">
                    @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description"
                              rows="4">{{ old('description', $companyProfile->description) }}</textarea>
                    @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>

                    <a href="{{ route('companies.profile.show') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
