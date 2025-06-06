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

                    <div class="col-12">
                        <label for="summary" class="form-label">Résumé</label>
                        <textarea class="form-control" name="summary" id="summary" rows="10"
                                  placeholder="Parle un peu de toi...">{{ old('summary', $studentProfile->summary) }}</textarea>
                        @error('summary')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="contract_type_ids" class="form-label">Type de contrat recherché</label>

                        <select class="form-select" name="contract_type_ids[]" multiple>
                            @foreach ($studentProfile->contractTypes as $contractType)
                                <option value="{{ $contractType->id }}"
                                        @if (in_array($contractType->name, old('contract_type_ids', $studentProfile->contractTypes->pluck('name')->toArray())))
                                            selected
                                    @endif
                                >
                                    {{ $contractType->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('contract_type_ids')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        @error('contract_type_ids.*')
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

                        @error('domain_names.*')
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

                        @error('skill_names.*')
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

                                            <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
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

                                            <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
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

@endsection
