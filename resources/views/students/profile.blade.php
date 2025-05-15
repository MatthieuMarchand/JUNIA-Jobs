@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <form action="{{ route('students.profile.update') }}" method="POST" novalidate>
        @csrf
        @method("PATCH")

        <div class="mb-3">
            <label for="first_name" class="form-label">Ton prénom</label>
            <input type="text" class="form-control" name="first_name" autocomplete="first_name" value="{{ old('first_name') }}">
            @error('first_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Ton nom</label>
            <input type="text" class="form-control" name="last_name" autocomplete="last_name" value="{{ old('last_name') }}">
            @error('last_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Ton numéro de téléphone</label>
            <input type="tel" class="form-control" name="phone_number" autocomplete="phone_number" value="{{ old('phone_number') }}">
            @error('phone_number')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label">Description</label>
            <textarea type="text" class="form-control" name="summary" autocomplete="summary" value="{{ old('summary') }}" rows="3"></textarea>
            @error('summary')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
        </div>
    </form>
@endsection