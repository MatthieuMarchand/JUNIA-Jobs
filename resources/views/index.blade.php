@extends('layouts.base')

@section('title', 'Accueil')

@section('base-content')
    @include('components.index.header')

    <section class="section-background"></section>

    <section class="section-landing">
        <div class="titles">
            <h1>Réunir entreprises et étudiants</h1>
            <p>+20 entreprises partenaires et +120 ingénieurs étudiants</p>
        </div>

        <div class="fake-cv">
            <img src="{{ asset('images/test-cv.png') }}" alt="">
            <img src="{{ asset('images/test-cv.png') }}" alt="">
            <img src="{{ asset('images/test-cv.png') }}" alt="">
        </div>
    </section>

    <section class="section-content">
        <section>
            <h2>On vous accompagne</h2>

            <div>
                <div>
                    <div>
                        <p>Étudiants</p>

                        <h3>Créez et partagez votre profil</h3>
                    </div>

                    <div>
                        <p>Un format normalisé qui laisse place au contenu :</p>

                        <ul>
                            <li>Résumé de votre profil</li>
                            <li>Expériences et formations</li>
                            <li>Compétences liées</li>
                            <li>Recommandations</li>
                        </ul>
                    </div>

                    <a href="{{ route('students.register.index') }}">Créer un compte étudiant</a>
                </div>

                <div>
                    <div>
                        <p>Entreprises</p>

                        <h3>Trouvez vos prochains collègues</h3>
                    </div>

                    <div>
                        <p>Filtrez selon vos critères :</p>

                        <ul>
                            <li>type de contrat (apprentissage, stages, mobilité internationale, CDI)</li>
                            <li>compétences</li>
                            <li>mots-clés dans les expériences</li>
                        </ul>
                    </div>

                    <a href="{{ route('companies.register.index') }}">Créer un compte entreprise</a>
                </div>
            </div>
        </section>

        <section>
            <h2>+ 20 entreprises partenaires</h2>

            <div>
                @foreach($companiesWithLogo as $company)
                    <img src="{{ $company->temporaryPhotoUrl() }}" alt="">
                @endforeach
            </div>
        </section>

    </section>

@endsection
