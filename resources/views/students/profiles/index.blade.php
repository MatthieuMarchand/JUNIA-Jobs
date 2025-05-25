@extends('layouts.app')

@section('title', 'Les Étudiants')

@section('content')
<div class="container mt-4">
    <h1>Liste des Profils Étudiants</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Filtres</div>
        <div class="card-body">
            <form action="{{ route('companies.students') }}" method="get">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="research_domain_names">Domaines</label>
                        <select name="research_domain_names[]" id="research_domain_names" class="form-control" multiple>
                            @foreach ($domains as $domain)
                                <option value="{{ $domain->name }}" {{ in_array($domain->name, request('research_domain_names', [])) ? 'selected' : '' }}>
                                    {{ $domain->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs domaines</small>
                    </div>

                    <div class="col-md-4">
                        <label for="skill_names">Compétences</label>
                        <select name="skill_names[]" id="skill_names" class="form-control" multiple>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->name }}" {{ in_array($skill->name, request('skill_names', [])) ? 'selected' : '' }}>
                                    {{ $skill->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs compétences</small>
                    </div>

                    <div class="col-md-4">
                        <label for="contract_type_ids">Types de contrat</label>
                        <select name="contract_type_ids[]" id="contract_type_ids" class="form-control" multiple>
                            @foreach ($contractTypes as $contractType)
                                <option value="{{ $contractType->id }}" {{ in_array($contractType->id, request('contract_type_ids', [])) ? 'selected' : '' }}>
                                    {{ $contractType->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs types</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="{{ route('companies.students') }}" class="btn btn-secondary">Réinitialiser</a>
            </form>
        </div>
    </div>

    @if($students && $students->count() > 0)
        <div class="row">
            @foreach($students as $student)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            @php
                                $photoUrl = $student->temporaryPhotoUrl();
                            @endphp

                            <div class="d-flex mb-3">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="Photo de {{ $student->first_name }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <span>Pas de photo</span>
                                    </div>
                                @endif
                                <div class="ms-3">
                                    <h5 class="card-title">{{ $student->first_name }} {{ $student->last_name }}</h5>
                                    @if($student->phone_number)
                                        <p class="card-text"><strong>Téléphone :</strong> {{ $student->phone_number }}</p>
                                    @endif
                                </div>
                            </div>

                            @if($student->summary)
                                <p class="card-text text-muted"><em>{{$student->summary}}</em></p>
                            @endif

                            @if($student->domains && $student->domains->count() > 0)
                                <p><strong>Domaines :</strong>
                                    {{ $student->domains->pluck('name')->implode(', ') }}
                                </p>
                            @endif

                            @if($student->skills && $student->skills->count() > 0)
                                <p><strong>Compétences :</strong>
                                    {{ $student->skills->pluck('name')->implode(', ') }}
                                </p>
                            @endif

                            @if($student->contractTypes && $student->contractTypes->count() > 0)
                                <p><strong>Types de contrat :</strong>
                                    {{ $student->contractTypes->pluck('name')->implode(', ') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <p>Aucun profil étudiant n'a été trouvé pour le moment.</p>
        </div>
    @endif
</div>
@endsection
