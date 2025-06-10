@props(['studentProfile'])
<div class="row">
    <div class="col-md-4">
        <section class="card">
            <div class="card-body text-center">
                @if($studentProfile->photo_path)
                    <img src="{{ $studentProfile->temporaryPhotoUrl() }}" alt="" class="mb-3"
                         style="width: 200px; height: 200px; object-fit: cover;">
                @endif

                <h2 class="card-title">{{ $studentProfile->fullName() }}</h2>

                @if($studentProfile->phone_number)
                    <p class="mb-2">
                        <i class="bi bi-telephone"></i> {{ $studentProfile->phone_number }}
                    </p>
                @endif

                <p class="mb-2">
                    <i class="bi bi-envelope"></i> {{ $studentProfile->user->email }}
                </p>

                <!-- NEW: Mobility Information -->
                @if($studentProfile->driver_license || $studentProfile->vehicle)
                    <div class="mt-3">
                        @if($studentProfile->driver_license)
                            <span class="badge text-bg-success me-1">
                                <i class="bi bi-credit-card-2-front"></i> Permis de conduire
                            </span>
                        @endif
                        @if($studentProfile->vehicle)
                            <span class="badge text-bg-success">
                                <i class="bi bi-car-front"></i> Véhicule
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <section class="card mt-4">
            <div class="card-body">
                <h3>Compétences</h3>

                @if($studentProfile->skills?->count())
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($studentProfile->skills as $skill)
                            <span class="badge text-bg-primary">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Aucune compétence spécifiée</p>
                @endif
            </div>
        </section>

        <section class="card mt-4">
            <div class="card-body">
                <h3>Domaines</h3>

                @if($studentProfile->domains?->count())
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($studentProfile->domains as $domain)
                            <span class="badge text-bg-secondary">{{ $domain->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Aucun domaine spécifié</p>
                @endif
            </div>
        </section>

        <!-- NEW: Hobbies Section -->
        @if($studentProfile->hobbies?->count())
        <section class="card mt-4">
            <div class="card-body">
                <h3>Centres d'intérêt</h3>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($studentProfile->hobbies as $hobby)
                        <span class="badge text-bg-info">{{ $hobby->hobby_name }}</span>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="card mt-4">
            <div class="card-body">
                <h3>Types de contrat recherchés</h3>

                @if($studentProfile->contractTypes?->count())
                    <ul class="list-group list-group-flush">
                        @foreach($studentProfile->contractTypes as $contractType)
                            <li class="list-group-item">
                                <strong>{{ $contractType->name }}</strong>
                                @if($contractType->description)
                                    <p class="text-muted small mb-1">{{ $contractType->description }}</p>
                                @endif
                                @if($contractType->pivot->contract_duration)
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-clock"></i> <strong>Durée:</strong> {{ $contractType->pivot->contract_duration }}
                                    </p>
                                @endif
                                @if($contractType->pivot->work_study_rhythm)
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-calendar-week"></i> <strong>Rythme:</strong> {{ $contractType->pivot->work_study_rhythm }}
                                    </p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucun type de contrat spécifié</p>
                @endif
            </div>
        </section>
    </div>

    <div class="mt-5 mt-md-0 col-md-8">
        <section>
            <h3>Présentation</h3>
            <div class="card-body">
                @if($studentProfile->summary)
                    <p class="whitespace-pre">{{ $studentProfile->summary }}</p>
                @else
                    <p class="text-muted">Aucune présentation disponible</p>
                @endif
            </div>
        </section>

        <!-- NEW: Certifications Section -->
        @if($studentProfile->certifications?->count())
        <section class="mt-5">
            <h3>Certifications</h3>
            <div class="row">
                @foreach($studentProfile->certifications as $certification)
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $certification->title }}</h5>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-calendar3"></i> {{ $certification->date_obtained->translatedFormat('M Y') }}
                                </p>
                                @if($certification->description)
                                    <p class="card-text">{{ $certification->description }}</p>
                                @endif
                                @if($certification->link)
                                    <a href="{{ $certification->link }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-link-45deg"></i> Voir la certification
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        <section class="mt-5">
            <h3>Expériences professionnelles</h3>

            @if($studentProfile->professionalExperiences?->count())
                <div class="timeline">
                    @foreach($studentProfile->professionalExperiences as $experience)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $experience->title }}
                                    @if($experience->contract_type)
                                        - {{ $experience->contract_type }}
                                    @endif
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ $experience->company_name }}
                                    @if($experience->location)
                                        - {{ $experience->location }}
                                    @endif
                                </h6>
                                <p class="card-text text-muted">
                                    {{ $experience->start->translatedFormat('M Y') }} -
                                    {{ $experience->end?->translatedFormat('M Y') ?? 'Présent' }}
                                </p>
                                <p class="card-text whitespace-pre">{{ $experience->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Aucune expérience professionnelle renseignée</p>
            @endif
        </section>

        <section class="mt-5">
            <h3>Formations</h3>

            @if($studentProfile->academicRecords?->count())
                <div class="timeline">
                    @foreach($studentProfile->academicRecords as $record)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $record->institution }}
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ $record->degree }}
                                </h6>
                                <p class="card-text text-muted">
                                    {{ $record->start->translatedFormat('M Y') }} -
                                    {{ $record->end?->translatedFormat('M Y') ?? 'Présent' }}
                                </p>
                                <p class="card-text whitespace-pre">{{ $record->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Aucune formation renseignée</p>
            @endif
        </section>
    </div>
</div>
