@extends('layouts.app')

@section('title', 'Mes invitations d\'entretien')

@section('content')
<div class="container mt-4">
    <h1>Mes invitations d'entretien</h1>

    <div class="mb-4">
        <a href="{{ route('students.profile.show') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour à mon profil
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($invitations->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Entreprise</th>
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
                                @if($invitation->companyProfile)
                                    {{ $invitation->companyProfile->name }}
                                @else
                                    <span class="text-muted">Entreprise supprimée</span>
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

                                @if($invitation->invitation_status === 'sent' || $invitation->invitation_status === 'read')
                                    <div class="mt-2">
                                        <form action="{{ route('students.invitations.accept', $invitation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Accepter</button>
                                        </form>

                                        <form action="{{ route('students.invitations.decline', $invitation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Refuser</button>
                                        </form>
                                    </div>
                                @endif
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
                            <p><strong>Message reçu :</strong></p>
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
            Vous n'avez pas encore reçu d'invitations à des entretiens.
        </div>
    @endif
</div>
@endsection