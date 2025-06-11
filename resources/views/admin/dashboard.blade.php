@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="container">
        <h1>Panel administrateur</h1>
        <div class="row mt-4 g-3">
            <div class="col-6">
                <section class="card shadow p-4">
                    <h2 class="mb-4">{{ $companiesApprovedCount > 1 ? "$companiesApprovedCount entreprises inscrites" : "1 entreprise inscrite" }}</h2>

                    <a class="btn btn-primary me-auto" href="{{ route('admin.companies.index') }}">Voir les entreprises</a>
                </section>
            </div>

            <div class="col-6">
                <section class="card shadow p-4">
                    <h2 class="mb-4">{{ $companiesRequestsCount > 1 ? "$companiesRequestsCount entreprises en attente" : "1 entreprise en attente" }}</h2>

                    <p>Vérifiez et validez les demandes d'inscription d'entreprises.</p>

                    <a class="btn btn-primary me-auto" href="{{ route('admin.companies.requests.index') }}">Voir les demandes</a>
                </section>
            </div>
        </div>
    </section>
@endsection
