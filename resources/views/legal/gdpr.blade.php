@extends('layouts.app')

@section('title', 'RGPD')

@section('content')
    <section class="container lg:mt-5">
        <h1>Politique RGPD</h1>

        <section class="card text-bg-dark p-3 mt-5">
            <h2>Pour comprendre rapidement</h2>
            <p>Nous collections le minimum de données pour faire fonctionner le site. <strong>Aucune donnée n'est revendue ou partagée à un
                    tiers.</strong></p>
            <p>Les données collectées sont:</p>
            <ul>
                <li>Adresse email</li>
                <li>Nom</li>
                <li>Ville</li>
                <li>Photo</li>
                <li>Numéro de Téléphone</li>
                <li>Expériences professionnelles</li>
                <li>Formations scolaires</li>
            </ul>

            <p>
                Ces informations restent internes au site et ne sont accessibles que par les utilisateurs ayant un compte sur le Site : Entreprises,
                Étudiants, Administrateurs. Seuls les noms/logos des entreprises sont rendus publics à tout visiteurs.
            </p>
            <p>Les photos des étudiants ne consultables qu'avec des urls temporaires, renforçant leur confidentialité.</p>
        </section>

        <h2 class="mt-5">Définitions</h2>
        <p>Sur cette page,</p>
        <p>"Site" est employé pour faire référence au site {{ config('app.url') }}</p>
        <p>"Utilisateur" est employé pour faire référence à toute personne naviguant sur le Site.</p>

        <h2 class="mt-5">Responsables de la collecte des données personnelles</h2>
        <p>
            Pour les Données Personnelles collectées dans le cadre de la création du compte
            personnel de l’Utilisateur et de sa navigation sur le Site, le responsable du traitement des
            Données Personnelles est : PROUST Arthaud, représentant légal du Site.
        </p>
        <p>
            En tant que responsable du traitement des données qu’il collecte, le Site
            s’engage à respecter le cadre des dispositions légales en vigueur. Il lui appartient
            notamment d’établir les finalités de ses traitements de données, de fournir à ses
            prospects et clients, à partir de la collecte de leurs consentements, une information
            complète sur le traitement de leurs données personnelles et de maintenir un registre des
            traitements conforme à la réalité. Chaque fois que le Site traite des Données
            Personnelles, le Site prend toutes les mesures raisonnables pour s’assurer de
            l’exactitude et de la pertinence des Données Personnelles au regard des finalités pour
            lesquelles le Site les traite.
        </p>

        <h2 class="mt-5">Finalité des données collectées</h2>
        <p>
            le Site est susceptible de traiter tout ou partie des données :
        </p>
        <ol class="list-disc ml-5 space-y-2 mb-2">
            <li>pour permettre la navigation sur l’interface d’administration du Site: données de connexion et de
                contact (email).
            </li>
            <li>pour l'affichage des candidatures et l'envoi d'invitations.</li>
        </ol>
        le Site ne commercialise pas vos données personnelles qui sont donc uniquement utilisées par
        nécessité ou à des fins statistiques et d’analyses.
        <p></p>

        <h2 class="mt-5">Droit d’accès, de rectification et d’opposition</h2>
        <p>
            Conformément à la réglementation européenne en vigueur, les Utilisateurs de
            le Site disposent des droits suivants :
        </p>
        <ul class="list-disc ml-5 space-y-2 mb-2">
            <li>droit d'accès (article 15 RGPD) et de rectification (article 16 RGPD), de mise à jour, de complétude
                des données des Utilisateurs droit de verrouillage ou d’effacement des données des Utilisateurs à
                caractère personnel (article 17 du RGPD), lorsqu’elles sont inexactes, incomplètes, équivoques,
                périmées, ou dont la collecte, l'utilisation, la communication ou la conservation est interdite
            </li>
            <li>droit de retirer à tout moment un consentement (article 13-2c RGPD)</li>
            <li>droit à la limitation du traitement des données des Utilisateurs (article 18 RGPD)</li>
            <li>droit d’opposition au traitement des données des Utilisateurs (article 21 RGPD)</li>
            <li>droit à la portabilité des données que les Utilisateurs auront fournies, lorsque ces données font
                l’objet de traitements automatisés fondés sur leur consentement ou sur un contrat (article 20 RGPD)
            </li>
            <li>droit de définir le sort des données des Utilisateurs après leur mort et de choisir à qui
                le Site devra communiquer (ou non) ses données à un tiers qu’ils aura préalablement
                désigné
            </li>
        </ul>
        Dès que le Site a connaissance du décès d’un Utilisateur et à défaut
        d’instructions de sa part, le Site s’engage à détruire ses données, sauf si leur
        conservation s’avère nécessaire à des fins probatoires ou pour répondre à une obligation légale.
        <p></p>
        <p>
            Si l’Utilisateur souhaite savoir comment le Site utilise ses Données
            Personnelles, demander à les rectifier ou s’oppose à leur traitement, l’Utilisateur peut
            contacter le Site par mail à l’adresse suivante : {{ config('app.publication_owner_email') }}
        </p>
        <p>
            Dans ce cas, l’Utilisateur doit indiquer les Données Personnelles qu’il souhaiterait que
            le Site corrige, mette à jour ou supprime, en s’identifiant précisément avec une
            copie d’une pièce d’identité (carte d’identité ou passeport).
        </p>
        <p>
            Les demandes de suppression de Données Personnelles seront soumises aux obligations
            qui sont imposées à le Site par la loi, notamment en matière de conservation ou
            d’archivage des documents. Enfin, les Utilisateurs de le Site peuvent déposer
            une réclamation auprès des autorités de contrôle, et notamment de la <a target="blank" class="link"
                                                                                    href="https://www.cnil.fr/fr/plaintes">CNIL</a>.
        </p>
        <h2 class="mt-5">Non-communication des données personnelles</h2>
        <p>
            le Site s’interdit de traiter, héberger ou transférer les Informations collectées sur
            ses Clients vers un pays situé en dehors de l’Union européenne ou reconnu comme « non
            adéquat » par la Commission européenne sans en informer préalablement le client. Pour
            autant, le Site reste libre du choix de ses sous-traitants techniques et
            commerciaux à la condition qu’il présentent les garanties suffisantes au regard des
            exigences du Règlement Général sur la Protection des Données (RGPD : n° 2016-679).
        </p>
        <p>
            le Site s’engage à prendre toutes les précautions nécessaires afin de préserver
            la sécurité des Informations et notamment qu’elles ne soient pas communiquées à des
            personnes non autorisées. <sub>©JUNIA Jobs</sub>
            <br>Cependant, si un incident impactant l’intégrité ou la
            confidentialité des Informations du Client est portée à la connaissance de le Site
            celle-ci devra dans les meilleurs délais informer le Client et lui communiquer les mesures
            de corrections prises. Par ailleurs le Site ne collecte aucune « données
            sensibles ».
        </p>
        <p>
            Les Données Personnelles de l’Utilisateur peuvent être traitées par des filiales de
            le Site et des sous-traitants (prestataires de services), exclusivement afin de
            réaliser les finalités de la présente politique.
            <br>Dans la limite de leurs attributions respectives et pour les finalités rappelées ci-dessus, les
            principales personnes susceptibles d’avoir accès aux données des Utilisateurs de
            le Site sont principalement les agents du service d’administration de escalade-montesquieu.
        </p>
        <h2 class="mt-5">Notification d’incident</h2>
        <p>
            Quels que soient les efforts fournis, aucune méthode de transmission sur Internet et
            aucune méthode de stockage électronique n'est complètement sûre. Nous ne pouvons en
            conséquence pas garantir une sécurité absolue.
            <br>Si nous prenions connaissance d'une
            brèche de la sécurité, nous avertirions les utilisateurs concernés afin qu'ils puissent
            prendre les mesures appropriées. Nos procédures de notification d’incident tiennent
            compte de nos obligations légales, qu'elles se situent au niveau national ou européen.
        </p>
        <p>
            Nous nous engageons à informer pleinement nos clients de toutes les questions relevant
            de la sécurité de leur compte et à leur fournir toutes les informations nécessaires pour les
            aider à respecter leurs propres obligations réglementaires en matière de reporting.
        </p>
        <p>
            Aucune information personnelle de l'utilisateur du site le Site n'est publiée à
            l'insu de l'utilisateur, échangée, transférée, cédée ou vendue sur un support quelconque à
            des tiers.
            <br>Seule l'hypothèse du rachat de le Site et de ses droits permettrait la
            transmission des dites informations à l'éventuel acquéreur qui serait à son tour tenu de la
            même obligation de conservation et de modification des données vis à vis de l'utilisateur
            du site le Site
        </p>
        <h2 class="mt-5">Sécurité</h2>
        <p>
            Pour assurer la sécurité et la confidentialité des Données Personnelles le Site utilise
            des réseaux protégés par des dispositifs
            standards tels que par pare-feu, l’encryption et mot de passe.
            <br>le Site ne traite aucune Données Personnelles de Santé.
        </p>
        <p>
            Lors du traitement des Données Personnelles, le Site prend toutes les mesures
            raisonnables visant à les protéger contre toute perte, utilisation détournée, accès non
            autorisé, divulgation, altération ou destruction.
        </p>
        <h2>Droit applicable et attribution de juridiction.</h2>
        <p>
            Tout litige en relation avec l’utilisation du site le Site est soumis au droit français.
            En dehors des cas où la loi ne le permet pas, il est fait attribution exclusive de juridiction
            aux tribunaux compétents de Bordeaux.
        </p>
    </section>
@endsection
