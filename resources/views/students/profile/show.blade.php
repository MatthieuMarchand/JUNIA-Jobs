@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h2 class="mb-4">Mon profil</h2>

            <form action="{{ route('students.profile.edit') }}" method="GET" novalidate>
                <fieldset disabled>
                    @csrf

                    <div class="mb-3">
                        <label for="first_name" class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            value="{{ $studentProfile->first_name }}"
                            placeholder="Jean" autocomplete="given-name">
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            value="{{ $studentProfile->last_name }}"
                            placeholder="Dupont" autocomplete="family-name">
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" name="phone_number" id="phone_number"
                            value="{{ $studentProfile->phone_number }}"
                            placeholder="06 00 00 00 00" autocomplete="tel">
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Description</label>
                        <textarea class="form-control" name="summary" id="summary" rows="4"
                            placeholder="Parle un peu de toi...">{{ $studentProfile->summary }}</textarea>
                    </div>

                    
                    <div class="mb-3">
                        <label for="contract_type_ids" class="form-label">Type de contrat recherché</label>

                        <ul class="list-group" name="contract_type_ids">
                            @foreach ($studentProfile->contractTypes as $contractType)
                                <li class="list-group-item list-group-item-dark">{{ $contractType->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </fieldset>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
@endsection
