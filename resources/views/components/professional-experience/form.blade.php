@props(['professionalExperience'=>null])
@php
    $submitText = ($professionalExperience ? 'Modifier': 'Ajouter') . " l'expérience";
    $route = $professionalExperience
        ? route('students.profile.professional-experiences.update', $professionalExperience)
        : route('students.profile.professional-experiences.store');
    $method = $professionalExperience ? 'PATCH' : 'POST';
@endphp

<div class="card mt-4">
    <div class="card-body">
        <form action="{{ $route }}" method="POST" class="row g-3" novalidate>
            {{-- Needed because PATCH is not supported by HTML forms--}}
            @method($method)

            @csrf

            <div class="col-12 col-md-6">
                <label for="title" class="form-label">Titre du poste</label>
                <input type="text" class="form-control" name="title" id="title"
                       value="{{ old('title', $professionalExperience?->title) }}">
                @error('title')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="company_name" class="form-label">Entreprise</label>
                <input type="text" class="form-control" name="company_name" id="company_name"
                       value="{{ old('company_name', $professionalExperience?->company_name) }}">
                @error('company_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="contract_type" class="form-label">Type de contrat</label>
                <input type="text" class="form-control" name="contract_type" id="contract_type"
                       value="{{ old('contract_type', $professionalExperience?->contract_type) }}">
                @error('contract_type')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="location" class="form-label">Localisation</label>
                <input type="text" class="form-control" name="location" id="location"
                       placeholder="Ville/télétravail"
                       value="{{ old('location', $professionalExperience?->location) }}">
                @error('location')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="start" class="form-label">Date de début</label>
                <input type="date" class="form-control" name="start" id="start"
                       value="{{ old('start', $professionalExperience?->start->toDateString()) }}">
                @error('start')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="end" class="form-label">Date de fin (optionnelle)</label>
                <input type="date" class="form-control" name="end" id="end"
                       value="{{ old('end', $professionalExperience?->end?->toDateString()) }}">
                @error('end')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="4"
                          placeholder="Résultat obtenu, programme, activités">{{ old('description', $professionalExperience?->description) }}</textarea>
                @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-primary">{{  $submitText }}</button>
            </div>
        </form>
    </div>
</div>
