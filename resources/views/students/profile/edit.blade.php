@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h2 class="mb-4">Modifier mon profil</h2>
            
            <form action="{{ route('students.profile.update') }}" method="POST" novalidate>
                @method("PATCH")
                @csrf

                <div class="mb-3">
                    <label for="first_name" class="form-label">Prénom</label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                           value="{{ old('first_name', $studentProfile->first_name) }}"
                           placeholder="Jean" autocomplete="given-name">
                    @error('first_name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                           value="{{ old('last_name', $studentProfile->last_name) }}"
                           placeholder="Dupont" autocomplete="family-name">
                    @error('last_name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" name="phone_number" id="phone_number"
                           value="{{ old('phone_number', $studentProfile->phone_number) }}"
                           placeholder="06 00 00 00 00" autocomplete="tel">
                    @error('phone_number')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Description</label>
                    <textarea class="form-control" name="summary" id="summary" rows="4"
                              placeholder="Parle un peu de toi...">{{ old('summary', $studentProfile->summary) }}</textarea>
                    @error('summary')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
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

                <div class="mb-3">
                    <label for="domain_names" class="form-label">Domaines de recherche</label>

                    <select class="form-select" data-create="true" name="domain_names[]" multiple>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->name }}"
                                    @if (in_array($domain->name, old('domain_names', $studentProfile->domains->pluck('name')->toArray())))
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

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>

                    <a href="{{ route('students.profile.show') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
