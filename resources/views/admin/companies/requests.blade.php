@extends('layouts.app')

@section('title', 'Demande d\'inscription envoyée')

@section('content')
    <section class="container">
        <h1>{{ $requests->count() }} entreprise(s) en attente</h1>
        <p class="mb-0">Accepter une demande enverra un mail à l'entreprise contenant un lien pour créer son mot de passe.</p>
        <p>Suite à ça, elle pourra remplir son profil et commencer à rechercher et contacter des étudiants.</p>

        <div class="row mt-4 g-3">
            @foreach($requests as $request)
                <div class="col-12 col-sm-6">
                    <article class="card shadow p-4">
                        <h2 class="mb-4">{{ $request->company_name }}</h2>

                        <p>{{ $request->message }}</p>

                        <form action="{{ route('admin.companies.requests.approve', $request->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success mb-2">Accepter</button>
                        </form>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
@endsection
