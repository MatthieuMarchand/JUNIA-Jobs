@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="card shadow p-4">
            <h2 class="mb-4">{{ $companiesApprovedCount }} entreprise(s) approuvée(s)</h2>
        </div>

        <div class="card shadow p-4">
            <h2 class="mb-4">{{ $companiesRequestsCount }} entreprise(s) en attente</h2>

            <p>Vérifiez et validez les demandes d'inscription d'entreprises.</p>

            <a class="button" href="{{ route('admin.companies.requests.index') }}">Voir les demandes</a>
        </div>
    </div>
@endsection
