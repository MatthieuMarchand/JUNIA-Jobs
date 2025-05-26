@extends('layouts.app')

@section('title', 'Mentions légales')

@section('content')
    <section class="container lg:mt-5">
        <h1>Conditions d'utilisation</h1>

        <h2 class="mt-5">Objet et définitions</h2>
        <p>
            Les présentes « conditions générales d'utilisation » ont pour objet l'encadrement juridique de
            l’utilisation du site <b>{{ config('app.url') }}</b> et de ses services.
        </p>
        <p>
            Ce contrat est conclu entre :
        </p>
        <ul>
            <li>
                Le gérant du site internet, ci-après désigné «&nbsp;l’Éditeur&nbsp;»
            </li>
            <li>
                Toute personne physique ou morale souhaitant accéder au site et à ses services, ci-après appelé «&nbsp;l’Utilisateur&nbsp;».
            </li>
            <li>
                Tout Utilisateur s'étant identifié à l’aide de ses identifiants de connexion, ci-après appelé «&nbsp;Membre&nbsp;».
            </li>
        </ul>
        <p>
            L'accès au site vaut acceptation de présentes conditions d'utilisation.
        </p>
        <p>
            Les Membres dotés d'un compte entreprise sont nommées ci-après «&nbsp;Entreprise membres&nbsp;».
        </p>
        <p>
            Les Membres dotés d'un compte étudiant sont nommées ci-après «&nbsp;Étudiants membres&nbsp;».
        </p>

        <h2 class="mt-5">Mentions légales</h2>
        <p>
            Les mentions légales du site sont accessibles ici :
            <a class="link" href="{{ route('legal.index') }}">Mentions&nbsp;légales</a>.
        </p>

        <h2 class="mt-5">Accès aux services</h2>
        <p>
            Les Entreprises membres du Site ont accès aux services suivants :
        </p>
        <ul>
            <li>Annuaire des étudiants</li>
            <li>Proposer un rendez-vous à un étudiant</li>
            <li>Liste des rendez-vous proposés</li>
        </ul>
        <p>
            Les Étudiants membres du Site ont accès aux services suivants :
        </p>
        <ul>
            <li>Annuaire des entreprises</li>
            <li>Liste des rendez-vous proposés</li>
        </ul>
        <p>
            Tout Utilisateur ayant accès a internet peut accéder gratuitement et depuis n’importe où au site. Les
            frais supportés par l’Utilisateur pour y accéder (connexion internet, matériel informatique, etc.) ne
            sont pas à la charge de l’Éditeur.
        </p>
        <p>
            Le site et ses différents services peuvent être interrompus ou suspendus par l’Éditeur, notamment à
            l’occasion d’une maintenance, sans obligation de préavis ou de justification.
        </p>

        <h2 class="mt-5">Responsabilité de l’Utilisateur</h2>
        <p>
            L'Utilisateur est responsable des risques liés à l’utilisation de son identifiant de connexion et de son
            mot de passe.
            Le mot de passe de l’Utilisateur doit rester secret. En cas de divulgation de mot de passe, l’Éditeur
            décline toute responsabilité.
        </p>
        <p>
            L'Utilisateur s'engage à communiquer sa véritable identité lors de son inscription, et à ne pas usurper
            l'identité d'un tiers en modifiant le nom de son compte.
            La possibilité de changer son prénom est conservée en cas d'erreur de frappe lors de l'inscription.
        </p>
        <p>
            L’Utilisateur assume l’entière responsabilité de l’utilisation qu’il fait des informations et contenus
            présents sur le Site.
        </p>
        <p>
            Tout usage du service par l'Utilisateur ayant directement ou indirectement pour conséquence des dommages
            doit faire l'objet d'une indemnisation au profit du site.
        </p>
        <p>
            Le site permet aux Membres de publier sur le site :
        </p>
        <ul>
            <li>Descriptions</li>
            <li>Liens</li>
            <li>Photo de profil</li>
        </ul>
        <p>
            Le Membre s’engage à tenir des propos respectueux des autres et de la loi et accepte que ces
            publications
            soient modérées ou refusées par l’Éditeur, sans obligation de justification.
            <br>Aussi, la publication d’un commentaire ou d’un article sur le site ou nos réseaux sociaux, de type
            raciste, homophobe, ou discours incitant à la haine est prohibé et sera immédiatement supprimé. Ce
            dernier
            pourra, au regard de la loi française faire l’objet de sanctions ou de poursuite judiciaires à
            l'encontre de
            l'Utilisateur.
        </p>
        <p>
            En publiant sur le site, l’Utilisateur cède à la société éditrice le droit non exclusif et gratuit de
            représenter, reproduire, adapter, modifier, diffuser et distribuer sa publication, directement ou par un
            tiers autorisé.
        </p>

        <h2 class="mt-5">Responsabilité de l’Éditeur</h2>
        <p>
            Tout dysfonctionnement du serveur ou du réseau ne peut engager la responsabilité de l’Éditeur.
            De même, la responsabilité du site ne peut être engagée en cas de force majeure ou du fait imprévisible
            et insurmontable d'un tiers.
        </p>
        <p>
            Le Site s'engage à mettre en œuvre tous les moyens nécessaires pour
            garantir la sécurité et la confidentialité des données. Toutefois, il n’apporte pas une garantie de
            sécurité totale.
            L’Éditeur se réserve la faculté d’une non-garantie de la fiabilité des sources, bien que les
            informations diffusées su le site soient réputées fiables.
        </p>

        <h2 class="mt-5">Propriété intellectuelle</h2>
        <p>
            Les contenus du Site (logos, textes, éléments graphiques, vidéos, etc.)
            sont protégés par le droit d’auteur, en vertu du Code de la propriété intellectuelle.
            Toute reproduction, copie ou publication de ces différents contenus sans l'autorisation préalable
            l’Éditeur du site est strictement interdite. L'Utilisateur s'engage à demander un accord écrit de
            l'Éditeur avant toute reproduction, copie ou publication de ces différents contenus.
        </p>
        <p>
            L’Utilisateur est entièrement responsable de tout contenu qu’il met en ligne et il s’engage à ne pas
            porter atteinte à un tiers.<sub>©JUNIA Jobs</sub>
        </p>
        <p>
            L’Éditeur du site se réserve le droit de modérer ou de supprimer librement et à tout moment les contenus
            mis en ligne par les utilisateurs, et ce sans justification.
        </p>

        <h2 class="mt-5">Données personnelles</h2>
        <p>
            Voir aussi la
            <a class="link" href="{{ route('legal.gdpr') }}">Politique RGPD</a>
            du site.
        </p>
        <p>
            L’Utilisateur doit obligatoirement fournir des informations personnelles pour procéder à son inscription
            sur le site.
            <br>L’adresse électronique (e-mail) de l’utilisateur pourra notamment être utilisée par le site Escalade
            Montesquieu pour la communication d’informations diverses (newsletter) et la gestion du compte.
            En aucun cas les informations personnelles ne sont cédées, vendues ou louées à un tiers.
            <br>Le site garanti le respect de la vie privée de l’utilisateur, conformément à
            la loi n°78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés.
        </p>
        <p>
            Le site n'est pas déclaré auprès de la CNIL.
        </p>
        <p>
            En vertu des articles 39 et 40 de la loi en date du 6 janvier 1978, l'Utilisateur dispose d'un droit
            d'accès, de rectification, de suppression et d'opposition de ses données personnelles. L'Utilisateur
            exerce ce droit via :
        </p>
        <ul>
            <li>Un mail à {{ config('app.publication_owner_email') }}</li>
        </ul>

        <h2 class="mt-5">Liens hypertextes</h2>
        <p>
            Les domaines vers lesquels mènent les liens hypertextes présents sur le site n’engagent pas la
            responsabilité de l’Éditeur du Site, qui n’a pas le contrôle total sur ces
            liens.
        </p>
        <p>
            Il est possible pour un tiers de créer un lien vers une page du Site sans
            autorisation expresse de l’éditeur.
        </p>

        <h2 class="mt-5">Évolution des conditions générales d’utilisation</h2>
        <p>
            Le Site se réserve le droit de modifier les clauses de ces conditions
            d’utilisation à tout moment et sans justification.
        </p>

        <h2 class="mt-5">Durée du contrat</h2>
        <p>
            La durée du présent contrat est indéterminée. Le contrat produit ses effets à l'égard de l'Utilisateur à
            compter du début de l’utilisation du service.
        </p>

        <h2 class="mt-5">Droit applicable et juridiction compétente</h2>
        <p>
            Le présent contrat dépend de la législation française.
            En cas de litige non résolu à l’amiable entre l’Utilisateur et l’Éditeur, les tribunaux de Bordeaux sont
            compétents pour régler le contentieux.
        </p>
    </section>
@endsection
