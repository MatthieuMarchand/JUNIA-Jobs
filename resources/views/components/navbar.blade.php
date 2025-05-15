<nav class="navbar px-3 mb-3">
  <a class="navbar-brand" href="{{  route('home') }}">JUNIA Jobs</a>

  <ul class="nav nav-underline">
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('home') }}">Accueil</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">Lien n°1</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">Lien n°2</a>
    </li>

    <li class="nav-item">
        <a class="btn btn-primary" href="{{ route('login.index') }}">Se connecter</a>
    </li>
  </ul>
</nav>