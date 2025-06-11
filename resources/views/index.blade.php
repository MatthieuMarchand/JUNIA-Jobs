@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<section class="section-background"></section>

<section class="section-landing">
    <div class="titles">
        <h1>Réunir entreprises et étudiants</h1>
        <p>+20 entreprises partenaires et +120 ingénieurs étudiants</p>
    </div>

    <div class="fake-cv">
        <img src="{{ asset('images/test-cv.png') }}">
        <img src="{{ asset('images/test-cv.png') }}">
        <img src="{{ asset('images/test-cv.png') }}">
    </div>
</section>

<section class="section-content">
    <div>
        <h2>On vous accompagne</h2>

        <div>
            <div>
                <div>
                    <p>Etudiants</p>
    
                    <h3>Créez et partagez votre profil</h3>
                </div>

                <div>
                    <p>Un format normalisé qui laisse place au contenu :</p>
                    
                    <ul>
                        <li>Résumé de votre profil</li>
                        <li>Expériences et formations</li>
                        <li>Compétences liées</li>
                        <li>Recommandations</li>
                    </ul>
                </div>

                <a href="amazon.com">Créer un compte étudiant</a>
            </div>

            <div>
                <div>
                    <p>Entreprises</p>
    
                    <h3>Trouvez vos prochains collègues</h3>
                </div>

                <div>
                    <p>Un format normalisé qui laisse place au contenu :</p>
    
                    <ul>
                        <li>type de contrat (apprentissage, stages, mobilité internationale, CDI)</li>
                        <li>compétences</li>
                        <li>mots-clés dans les expériences</li>
                    </ul>
                </div>

                <a href="amazon.com">Créer un compte entreprise</a>
            </div>
        </div>
    </div>

    {{-- <div>
        <h2>+ 20 entreprises partenaires</h2>
    </div> --}}
</section>
@endsection
