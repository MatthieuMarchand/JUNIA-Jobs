@props(['academicRecord'=>null])
@php
    $submitText = ($academicRecord ? 'Modifier': 'Ajouter') . " la formation";
    $route = $academicRecord ? route('students.profile.academic-records.update', $academicRecord) : route('students.profile.academic-records.store');
    $method = $academicRecord ? 'PATCH' : 'POST';
@endphp

<div class="card mt-4">
    <div class="card-body">
        <form action="{{ $route }}" method="POST" class="row g-3" novalidate>
            {{-- Needed because PATCH is not supported by HTML forms--}}
            @method($method)

            @csrf

            <div class="col-12 col-md-6">
                <label for="institution" class="form-label">Institution</label>
                <input type="text" class="form-control" name="institution" id="institution"
                       value="{{ old('institution', $academicRecord?->institution) }}">
                @error('institution')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="degree" class="form-label">Formation</label>
                <input type="text" class="form-control" name="degree" id="degree"
                       value="{{ old('degree', $academicRecord?->degree) }}">
                @error('degree')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="start" class="form-label">Date de début</label>
                <input type="date" class="form-control" name="start" id="start"
                       value="{{ old('start', $academicRecord?->start->toDateString()) }}">
                @error('start')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="end" class="form-label">Date de fin (optionnelle)</label>
                <input type="date" class="form-control" name="end" id="end"
                       value="{{ old('end', $academicRecord?->end?->toDateString()) }}">
                @error('end')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="4"
                          placeholder="Résultat obtenu, programme, activités">{{ old('description', $academicRecord?->description) }}</textarea>
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
