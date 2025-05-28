@extends('layouts.app')

@section('title', $student->first_name . ' ' . $student->last_name)

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        @php
                            $photoUrl = $student->temporaryPhotoUrl();
                        @endphp

                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="Photo de {{ $student->first_name }}" class="img-thumbnail mb-3"
                                 style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center mb-3 mx-auto"
                                 style="width: 200px; height: 200px;">
                                <span>Pas de photo</span>
                            </div>
                        @endif

                        <h2 class="card-title">{{ $student->first_name }} {{ $student->last_name }}</h2>

                        @if($student->phone_number)
                            <p class="mb-2">
                                <i class="bi bi-telephone"></i> {{ $student->phone_number }}
                            </p>
                        @endif

                        <p class="mb-2">
                            <i class="bi bi-envelope"></i> {{ $student->user->email }}
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Compétences</div>
                    <div class="card-body">
                        @if($student->skills && $student->skills->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($student->skills as $skill)
                                    <span class="badge bg-primary">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucune compétence spécifiée</p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Domaines</div>
                    <div class="card-body">
                        @if($student->domains && $student->domains->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($student->domains as $domain)
                                    <span class="badge bg-success">{{ $domain->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucun domaine spécifié</p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Types de contrat recherchés</div>
                    <div class="card-body">
                        @if($student->contractTypes && $student->contractTypes->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($student->contractTypes as $contractType)
                                    <li class="list-group-item">
                                        <strong>{{ $contractType->name }}</strong>
                                        @if($contractType->description)
                                            <p class="text-muted small mb-0">{{ $contractType->description }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Aucun type de contrat spécifié</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Présentation</div>
                    <div class="card-body">
                        @if($student->summary)
                            <p>{{ $student->summary }}</p>
                        @else
                            <p class="text-muted">Aucune présentation disponible</p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Expériences professionnelles</div>
                    <div class="card-body">
                        @if($student->professionalExperiences && $student->professionalExperiences->count() > 0)
                            <div class="timeline">
                                @foreach($student->professionalExperiences as $experience)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $experience->title }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ $experience->company_name }}
                                                - {{ $experience->location }}</h6>
                                            <p class="card-text text-muted">
                                                {{ $experience->start->format('M Y') }} -
                                                {{ $experience->end ? $experience->end->format('M Y') : 'Présent' }}
                                            </p>
                                            <p class="card-text">{{ $experience->description }}</p>
                                            <p class="card-text"><small class="text-muted">Type de contrat: {{ $experience->contract_type }}</small>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucune expérience professionnelle renseignée</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>Inviter cet étudiant à un entretien</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('companies.students.invite', $student->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="invitation_date" class="form-label">Date proposée pour l'entretien</label>
                                <input type="date" class="form-control @error('invitation_date') is-invalid @enderror"
                                       id="invitation_date" name="invitation_date"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                @error('invitation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="invitation_details" class="form-label">Détails de l'invitation</label>
                                <textarea class="form-control @error('invitation_details') is-invalid @enderror"
                                          id="invitation_details" name="invitation_details" rows="4"
                                          placeholder="Décrivez le poste, le déroulement de l'entretien, etc." required></textarea>
                                @error('invitation_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Envoyer l'invitation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
