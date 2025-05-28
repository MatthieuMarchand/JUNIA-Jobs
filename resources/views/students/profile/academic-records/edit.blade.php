@extends('layouts.app')

@section('title', 'Modifier une formation')

@section('content')
    <section class="container">
        <h2 class="mb-4">Modifier une formation</h2>

        <div class="card mt-4">
            <div class="card-body">
                <form action="{{ route('students.profile.academic-records.update', $academicRecord) }}" method="POST" class="row g-3" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="col-12 col-md-6">
                        <label for="institution" class="form-label">Institution</label>
                        <input type="text" class="form-control" name="institution" id="institution"
                               value="{{ old('institution', $academicRecord->institution) }}">
                        @error('institution')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="degree" class="form-label">Formation</label>
                        <input type="text" class="form-control" name="degree" id="degree"
                               value="{{ old('degree', $academicRecord->degree) }}">
                        @error('degree')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="start" class="form-label">Date de début</label>
                        <input type="date" class="form-control" name="start" id="start"
                               value="{{ old('start', $academicRecord->start->toDateString()) }}">
                        @error('start')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="end" class="form-label">Date de fin (optionnelle)</label>
                        <input type="date" class="form-control" name="end" id="end"
                               value="{{ old('end', $academicRecord->end?->toDateString()) }}">
                        @error('end')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4"
                                  placeholder="Résultat obtenu, programme, activités">{{ old('description', $academicRecord->description) }}</textarea>
                        @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <button type="submit" class="btn btn-primary">Modifier la formation</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
