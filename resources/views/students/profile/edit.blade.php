@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <section class="container">
        <h2 class="mb-4">Modifier mon profil</h2>

        <div class="accordion" id="accordion">
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button
                        class="accordion-button @if(!$errors->has('pdf')) collapsed @endif"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="false"
                        aria-controls="collapseOne"
                    >
                        <span class="badge text-bg-primary me-2">Gagnez du temps !</span> Importez votre profil Linkedin
                    </button>
                </h3>
                <div id="collapseOne" class="accordion-collapse collapse @if($errors->has('pdf')) show @endif" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        <form action="{{ route('students.profile.import.linkedin') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <p>
                                <a href="https://www.linkedin.com/help/linkedin/answer/a547069/enregistrer-un-profil-au-format-pdf?lang=fr"
                                   target="_blank" rel="noreferrer">Téléchargez un PDF de votre profil Linkedin</a>, en français.
                            </p>
                            <p>
                                L'import va remplacer les informations de votre profil actuel.
                            </p>

                            <div class="mb-3">
                                <label for="pdf" class="form-label">Fichier PDF</label>
                                <input type="file" class="form-control" name="pdf" id="pdf" accept=".pdf">
                                @error('pdf')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Importer le PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h3>Informations de base</h3>

                <form action="{{ route('students.profile.update') }}" method="POST" class="row g-3" enctype="multipart/form-data" novalidate>
                    @method("PATCH")
                    @csrf

                    <div class="col-12">
                        <label for="photo" class="form-label">Photo de profil</label>
                        <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
                        <div class="form-text">Formats acceptés : JPG, PNG, GIF (max 5MB)</div>
                        @error('photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="first_name" class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                               value="{{ old('first_name', $studentProfile->first_name) }}"
                               placeholder="Jean" autocomplete="given-name">
                        @error('first_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="last_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                               value="{{ old('last_name', $studentProfile->last_name) }}"
                               placeholder="Dupont" autocomplete="family-name">
                        @error('last_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="phone_number" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" name="phone_number" id="phone_number"
                               value="{{ old('phone_number', $studentProfile->phone_number) }}"
                               placeholder="06 00 00 00 00" autocomplete="tel">
                        @error('phone_number')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NEW: Driver License and Vehicle Section -->
                    <div class="col-12">
                        <h4>Mobilité</h4>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="driver_license" id="driver_license" value="1"
                                   @if(old('driver_license', $studentProfile->driver_license)) checked @endif>
                            <label class="form-check-label" for="driver_license">
                                <i class="bi bi-credit-card-2-front"></i> Permis de conduire
                            </label>
                        </div>
                        @error('driver_license')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="vehicle" id="vehicle" value="1"
                                   @if(old('vehicle', $studentProfile->vehicle)) checked @endif>
                            <label class="form-check-label" for="vehicle">
                                <i class="bi bi-car-front"></i> Véhicule personnel
                            </label>
                        </div>
                        @error('vehicle')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="summary" class="form-label">Résumé</label>
                        <textarea class="form-control" name="summary" id="summary" rows="10"
                                  placeholder="Parle un peu de toi...">{{ old('summary', $studentProfile->summary) }}</textarea>
                        @error('summary')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- UPDATED: Contract Types with duration and rhythm -->
                    <div class="col-12">
                        <h4>Préférences de contrat</h4>
                        <div id="contract-preferences">
                            @foreach($studentProfile->contractTypes as $index => $contractType)
                                <div class="contract-preference-item border p-3 mb-3 rounded">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label for="contract_preferences_{{ $index }}_contract_type_id" class="form-label">Type de contrat</label>
                                            <select class="form-select" name="contract_preferences[{{ $index }}][contract_type_id]"
                                                    id="contract_preferences_{{ $index }}_contract_type_id">
                                                @foreach($contractTypes as $type)
                                                    <option value="{{ $type->id }}" @if($type->id == $contractType->id) selected @endif>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="contract_preferences_{{ $index }}_contract_duration" class="form-label">Durée
                                                souhaitée</label>
                                            <input type="text" class="form-control" name="contract_preferences[{{ $index }}][contract_duration]"
                                                   id="contract_preferences_{{ $index }}_contract_duration"
                                                   value="{{ old("contract_preferences.{$index}.contract_duration", $contractType->pivot->contract_duration) }}"
                                                   placeholder="Ex: 6 mois, 1 an, 2 ans...">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="contract_preferences_{{ $index }}_work_study_rhythm" class="form-label">Rythme
                                                d'alternance</label>
                                            <input type="text" class="form-control" name="contract_preferences[{{ $index }}][work_study_rhythm]"
                                                   id="contract_preferences_{{ $index }}_work_study_rhythm"
                                                   value="{{ old("contract_preferences.{$index}.work_study_rhythm", $contractType->pivot->work_study_rhythm) }}"
                                                   placeholder="Ex: 2j école / 3j entreprise">
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-danger btn-sm remove-contract-preference">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-primary" id="add-contract-preference">
                            <i class="bi bi-plus"></i> Ajouter un type de contrat
                        </button>
                        @error('contract_preferences')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="domain_names" class="form-label">Domaines de recherche</label>
                        <select class="form-select" data-create="true" name="domain_names[]" multiple>
                            @foreach ($domains as $domain)
                                <option value="{{ $domain->name }}"
                                        @if (in_array($domain->name, old('domain_names', $studentProfile->domains->pluck('name')->toArray()), true))
                                            selected
                                    @endif
                                >
                                    {{ $domain->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('domain_names')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="skill_names" class="form-label">Compétences</label>
                        <select class="form-select" data-create="true" name="skill_names[]" multiple>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->name }}"
                                        @if (in_array($skill->name, old('skill_names', $studentProfile->skills->pluck('name')->toArray()), true))
                                            selected
                                    @endif
                                >
                                    {{ $skill->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('skill_names')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NEW: Hobbies Section -->
                    <div class="col-12">
                        <h4>Centres d'intérêt</h4>
                        <div id="hobbies-container">
                            @foreach($studentProfile->hobbies as $index => $hobby)
                                <div class="hobby-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="hobbies[]"
                                               value="{{ old("hobbies.{$index}", $hobby->hobby_name) }}"
                                               placeholder="Ex: Football, Photographie, Cuisine...">
                                        <button type="button" class="btn btn-outline-danger remove-hobby">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-primary" id="add-hobby">
                            <i class="bi bi-plus"></i> Ajouter un centre d'intérêt
                        </button>
                        @error('hobbies')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NEW: Certifications Section -->
                    <div class="col-12">
                        <h4>Certifications</h4>
                        <div id="certifications-container">
                            @foreach($studentProfile->certifications as $index => $certification)
                                <div class="certification-item border p-3 mb-3 rounded">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="certifications_{{ $index }}_title" class="form-label">Titre de la certification</label>
                                            <input type="text" class="form-control" name="certifications[{{ $index }}][title]"
                                                   id="certifications_{{ $index }}_title"
                                                   value="{{ old("certifications.{$index}.title", $certification->title) }}"
                                                   placeholder="Ex: AWS Certified Solutions Architect">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="certifications_{{ $index }}_date_obtained" class="form-label">Date d'obtention</label>
                                            <input type="date" class="form-control" name="certifications[{{ $index }}][date_obtained]"
                                                   id="certifications_{{ $index }}_date_obtained"
                                                   value="{{ old("certifications.{$index}.date_obtained", $certification->date_obtained?->format('Y-m-d')) }}">
                                        </div>
                                        <div class="col-12">
                                            <label for="certifications_{{ $index }}_description" class="form-label">Description</label>
                                            <textarea class="form-control" name="certifications[{{ $index }}][description]"
                                                      id="certifications_{{ $index }}_description" rows="3"
                                                      placeholder="Description de la certification...">{{ old("certifications.{$index}.description", $certification->description) }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="certifications_{{ $index }}_link" class="form-label">Lien (optionnel)</label>
                                            <input type="url" class="form-control" name="certifications[{{ $index }}][link]"
                                                   id="certifications_{{ $index }}_link"
                                                   value="{{ old("certifications.{$index}.link", $certification->link) }}"
                                                   placeholder="https://example.com/certification">
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-danger btn-sm remove-certification">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-primary" id="add-certification">
                            <i class="bi bi-plus"></i> Ajouter une certification
                        </button>
                        @error('certifications')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h3>Formation</h3>

                <a class="btn btn-primary mb-4" href="{{route('students.profile.academic-records.create')}}">
                    <i class="bi bi-plus-lg"></i> Ajouter une formation
                </a>

                @foreach($studentProfile->academicRecords as $academicRecord)
                    @php
                        $modalId = "deleteAcademicRecord-$academicRecord->id"
                    @endphp
                    <div class="d-flex">
                        <div>
                            <h4 class="d-flex align-items-end gap-1">

                                {{ $academicRecord->institution }}

                                <a class="btn btn-secondary btn-sm" href="{{ route('students.profile.academic-records.edit', $academicRecord) }}">
                                    <i class="bi bi-pencil-fill"></i> <span class="visually-hidden">Modifier</span>
                                </a>
                                <button
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#{{ $modalId }}"
                                >
                                    <i class="bi bi-trash-fill"></i> <span class="visually-hidden">Supprimer</span>
                                </button>
                            </h4>
                            <p>{{ $academicRecord->degree }} ({{$academicRecord->start->translatedFormat("M Y")}}
                                - {{$academicRecord->end?->translatedFormat("M Y") ?? 'maintenant'}})</p>
                        </div>

                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="#{{ $modalId }}Label"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="{{ $modalId }}Label">Supprimer la formation {{$academicRecord->degree}}?</h1>
                                    </div>
                                    <div class="modal-body">
                                        C'est définitif.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('students.profile.academic-records.destroy', $academicRecord) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h3>Expérience professionnelles</h3>

                <a class="btn btn-primary mb-4" href="{{route('students.profile.professional-experiences.create')}}">
                    <i class="bi bi-plus-lg"></i> Ajouter une expérience
                </a>

                @foreach($studentProfile->professionalExperiences as $professionalExperience)
                    @php
                        $modalId = "deleteAcademicRecord-$professionalExperience->id"
                    @endphp
                    <div class="d-flex">
                        <div>
                            <h4 class="d-flex align-items-end gap-1">
                                {{ $professionalExperience->title }}

                                <a class="btn btn-secondary btn-sm"
                                   href="{{ route('students.profile.professional-experiences.edit', $professionalExperience) }}">
                                    <i class="bi bi-pencil-fill"></i> <span class="visually-hidden">Modifier</span>
                                </a>
                                <button
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#{{ $modalId }}"
                                >
                                    <i class="bi bi-trash-fill"></i> <span class="visually-hidden">Supprimer</span>
                                </button>
                            </h4>
                            <p>{{ $professionalExperience->company_name }} ({{$professionalExperience->start->translatedFormat("M Y")}}
                                - {{$professionalExperience->end?->translatedFormat("M Y") ?? 'maintenant'}})</p>
                        </div>

                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="#{{ $modalId }}Label"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="{{ $modalId }}Label">Supprimer
                                            l'expérience {{$professionalExperience->title}}
                                            chez {{$professionalExperience->company_name}}?</h1>
                                    </div>
                                    <div class="modal-body">
                                        C'est définitif.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('students.profile.professional-experiences.destroy', $professionalExperience) }}"
                                              method="POST">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        // Add dynamic form functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add hobby functionality
            let hobbyIndex = {{ $studentProfile->hobbies->count() }};
            document.getElementById('add-hobby').addEventListener('click', function() {
                const container = document.getElementById('hobbies-container');
                const newHobby = document.createElement('div');
                newHobby.className = 'hobby-item mb-2';
                newHobby.innerHTML = `
                    <div class="input-group">
                        <input type="text" class="form-control" name="hobbies[]" placeholder="Ex: Football, Photographie, Cuisine...">
                        <button type="button" class="btn btn-outline-danger remove-hobby">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                container.appendChild(newHobby);
            });

            // Remove hobby functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-hobby')) {
                    e.target.closest('.hobby-item').remove();
                }
            });

            // Add certification functionality
            let certificationIndex = {{ $studentProfile->certifications->count() }};
            document.getElementById('add-certification').addEventListener('click', function() {
                const container = document.getElementById('certifications-container');
                const newCertification = document.createElement('div');
                newCertification.className = 'certification-item border p-3 mb-3 rounded';
                newCertification.innerHTML = `
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Titre de la certification</label>
                            <input type="text" class="form-control" name="certifications[${certificationIndex}][title]" placeholder="Ex: AWS Certified Solutions Architect">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Date d'obtention</label>
                            <input type="date" class="form-control" name="certifications[${certificationIndex}][date_obtained]">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="certifications[${certificationIndex}][description]" rows="3" placeholder="Description de la certification..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Lien (optionnel)</label>
                            <input type="url" class="form-control" name="certifications[${certificationIndex}][link]" placeholder="https://example.com/certification">
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-danger btn-sm remove-certification">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(newCertification);
                certificationIndex++;
            });

            // Remove certification functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-certification')) {
                    e.target.closest('.certification-item').remove();
                }
            });

            // Add contract preference functionality
            let contractIndex = {{ $studentProfile->contractTypes->count() }};
            document.getElementById('add-contract-preference').addEventListener('click', function() {
                const container = document.getElementById('contract-preferences');
                const newContract = document.createElement('div');
                newContract.className = 'contract-preference-item border p-3 mb-3 rounded';
                newContract.innerHTML = `
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label">Type de contrat</label>
                            <select class="form-select" name="contract_preferences[${contractIndex}][contract_type_id]">
                                @foreach($contractTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label">Durée souhaitée</label>
                <input type="text" class="form-control" name="contract_preferences[${contractIndex}][contract_duration]" placeholder="Ex: 6 mois, 1 an, 2 ans...">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Rythme d'alternance</label>
                            <input type="text" class="form-control" name="contract_preferences[${contractIndex}][work_study_rhythm]" placeholder="Ex: 2j école / 3j entreprise">
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-danger btn-sm remove-contract-preference">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(newContract);
                contractIndex++;
            });

            // Remove contract preference functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-contract-preference')) {
                    e.target.closest('.contract-preference-item').remove();
                }
            });
        });
    </script>
@endsection
