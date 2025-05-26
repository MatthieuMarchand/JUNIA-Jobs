@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h2 class="mb-4">Votre profil entreprise</h2>

            <form action="{{ route('companies.profile.edit') }}" method="GET" novalidate>
                <fieldset disabled>
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
                                  rows="6">{{ old('description', $companyProfile->description) }}</textarea>
                        @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </fieldset>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
@endsection
