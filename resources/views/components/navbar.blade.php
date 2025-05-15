<nav class="navbar px-3 mb-3">
  <a class="navbar-brand" href="{{  route('home') }}"><strong>JUNIA Jobs</strong></a>

  <ul class="nav nav-underline">
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('students.profile.show') ? 'active' : '' }}" href="{{ route('students.profile.show') }}">Mon profil</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">Lien n°1</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">Lien n°2</a>
    </li>

    @guest
      <li class="nav-item">
          <a class="btn btn-primary" href="{{ route('login') }}">Se connecter</a>
      </li>
    @endguest
  </ul>
</nav>