<header>
    <a href="{{  route('home') }}">
        <img src="{{ asset('images/logos/junia_jobs.svg') }}" alt="Logo JUNIA Jobs">
    </a>

    <div id="burger">
        <div></div>
        <div></div>
        <div></div>
    </div>

  <nav>
      <ul>
          <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a></li>

          @if (auth()->user()?->role === App\Enums\UserRole::Student)
              <li>
                  <a class="{{ request()->routeIs('students.invitations.history') ? 'active' : '' }}" href="{{ route('students.invitations.history') }}">
                      Invitations
                  </a>
              </li>

              <li>
                  <a class="@if(in_array(request()->route()->getName(), ['students.profile.show', 'students.profile.edit'])) active @endif"
                    href="{{ route('students.profile.show') }}"
                  >
                      Mon profil
                  </a>
              </li>
          @endif

          @if (auth()->user()?->role === App\Enums\UserRole::Company)
              <li>
                  <a
                      class="{{ request()->routeIs('companies.students') ? 'active' : '' }}"
                      href="{{ route('companies.students') }}"
                  >
                      Trouver des étudiants
                  </a>
              </li>

              <li>
                  <a @if(request()->routeIs('companies.invitations.history')) active @endif"
                    href="{{ route('companies.invitations.history') }}"
                  >
                      Invitations envoyées
                  </a>
              </li>

              <li>
                  <a class="@if(in_array(request()->route()->getName(), ['companies.profile.show', 'companies.profile.edit'])) active @endif"
                    href="{{ route('companies.profile.show') }}"
                  >
                      Profil
                  </a>
              </li>
          @endif

          @if (auth()->user()?->role === App\Enums\UserRole::Administrator)
              <li>
                  <a
                      class="{{ request()->routeIs('admin.home') ? 'active' : '' }}"
                      href="{{ route('admin.home') }}"
                  >
                      Tableau administrateur
                  </a>
              </li>
          @endif
      </ul>
  </nav>

  <div>
    @guest
      <a href="{{ route('students.register.index') }}">S'inscrire</a>

      <a href="{{ route('login') }}">S'identifier</a>
    @endguest

    @auth
      <form action="{{ route('logout') }}" method="post">
          @csrf

          <button type="submit">Se déconnecter</button>
      </form>
    @endauth
  </div>
</header>