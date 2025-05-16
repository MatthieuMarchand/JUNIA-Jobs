@extends('layouts.app')

@section('title', 'Les Étudiants')

@section('content')
<div >
    <h1>Liste des Profils Étudiants</h1>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if($students && $students->count() > 0)
        <div>
            @foreach($students as $student)
                <div>
                    <div>
                        @php
                            $photoUrl = $student->temporaryPhotoUrl();
                        @endphp

                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="Photo de {{ $student->first_name }}">
                        @else
                            <div style="">
                                <span>Pas de photo</span>
                            </div>
                        @endif
                        <div >
                            <h5>{{ $student->first_name }} {{ $student->last_name }}</h5>
                            @if($student->summary)
                                <p><em>{{$student->summary}}</em></p>
                            @endif
                            <ul>
                                @if($student->phone_number)
                                    <li><strong>Téléphone :</strong> {{ $student->phone_number }}</li>
                                @endif
                            </ul>
                          </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div>
            <p>Aucun profil étudiant n'a été trouvé pour le moment.</p>
        </div>
    @endif
</div>
@endsection