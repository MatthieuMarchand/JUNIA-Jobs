@extends('layouts.app')

@section('title', 'Comptes étudiant')

@section('content')
    @php
        $studentsCount = $users->count();
    @endphp
    <section class="container">
        <h1>{{ $studentsCount > 1 ? "$studentsCount comptes étudiant" : "1 compte étudiant" }}</h1>

        <div class="row mt-4 g-3">
            @foreach($users as $user)
                @php
                    $modalId = "deleteUser-$user->id"
                @endphp
                <div class="col-12 col-sm-6">
                    <article class="card shadow p-4">
                        <h2 class="mb-4">{{ $user->studentProfile?->fullname() ?? "Sans nom" }}</h2>

                        <p>{{ $user->email }}</p>

                        <button
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $modalId }}"
                        >
                            <i class="bi bi-trash-fill"></i> Supprimer
                        </button>

                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="#{{ $modalId }}Label"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="{{ $modalId }}Label">
                                            Supprimer le compte étudiant {{$user->email}} ?
                                        </h1>
                                    </div>
                                    <div class="modal-body">
                                        C'est définitif.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.companies.destroy', $user) }}"
                                              method="POST">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
@endsection
