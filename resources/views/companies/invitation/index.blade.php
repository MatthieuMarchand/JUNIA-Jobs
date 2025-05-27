@extends('layouts.app')

@section('title', 'Historique des invitations')

@section('content')
<div class="container mt-4">
    <h1>Historique des invitations</h1>

    <div class="mb-4">
        <a href="{{ route('companies.students') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour à la liste des étudiants
        </a>
    </div>

    @if($invitations->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Date d'envoi</th>
                        <th>Date d'entretien</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invitations as $invitation)
                        <tr>
                            <td>
                                @if($invitation->studentProfile)
                                    <a href="{{ route('companies.students.show', $invitation->studentProfile->id) }}">
                                        {{ $invitation->studentProfile->first_name }} {{ $invitation->studentProfile->last_name }}
                                    </a>
                                @else
                                    <span class="text-muted">Étudiant supprimé</span>
                                @endif
                            </td>
                            <td>{{ $invitation->sent->format('d/m/Y H:i') }}</td>
                            <td>{{ $invitation->invitation_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $invitation->invitation_status === 'sent' ? 'warning' :
                                    ($invitation->invitation_status === 'accepted' ? 'success' :
                                    ($invitation->invitation_status === 'declined' ? 'danger' : 'info')) }}">
                                    {{ $invitation->getStatusLabel() }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $invitation->id }}">
                                    Détails
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $invitations->links() }}

        @foreach($invitations as $invitation)
            <div class="modal fade" id="detailsModal{{ $invitation->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $invitation->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel{{ $invitation->id }}">Détails de l'invitation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Message envoyé :</strong></p>
                            <p>{{ $invitation->invitation_details }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            Vous n'avez pas encore envoyé d'invitations à des étudiants.
        </div>
    @endif
</div>
@endsection