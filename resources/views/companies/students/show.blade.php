@extends('layouts.app')

@section('title', $student->fullName())

@section('content')
    <section class="container">
        <button type="button" class="mb-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#invitModal">
            Inviter à un entretien
        </button>

        <x-student-profile :student-profile="$student" />

        <div id="invitModal" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inviter cet étudiant à un entretien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body" action="{{ route('companies.students.invite', $student->id) }}" method="POST">
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
    </section>
@endsection
