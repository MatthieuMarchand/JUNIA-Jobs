@extends('layouts.app')

@section('title', 'Demande d\'inscription envoyée')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow p-4" style="max-width: 450px; width: 100%;">
            <h2 class="mb-4 text-center">Demande d'inscription envoyée !</h2>

            <p class="text-center mb-0">
                Vous recevrez un mail avec les informations de connexion lorsque la demande sera acceptée.
            </p>
        </div>
    </div>
@endsection
