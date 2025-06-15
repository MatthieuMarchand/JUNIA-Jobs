<div class="container">

    <nav class="navbar mb-3">
        <a class="navbar-brand" href="{{  route('home') }}"><strong>JUNIA Jobs</strong></a>

        <ul class="nav nav-underline">
            @guest
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('login') }}">Se connecter</a>
                </li>
            @endguest

            @auth
                @php
                    $userRole = auth()->user()->role
                @endphp

                @if ($userRole === App\Enums\UserRole::Student)
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('students.invitations.history')) active @endif"
                           href="{{ route('students.invitations.history') }}"
                        >
                            Invitations
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(in_array(request()->route()->getName(), ['students.profile.show', 'students.profile.edit'])) active @endif"
                           href="{{ route('students.profile.show') }}"
                        >
                            Profil
                        </a>
                    </li>
                @endif

                @if ($userRole === App\Enums\UserRole::Company)
                    <li class="nav-item">
                        <a
                            class="nav-link
                    {{ request()->routeIs('companies.students') ? 'active' : '' }}"
                            href="{{ route('companies.students') }}"
                        >
                            Étudiants
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('companies.invitations.history')) active @endif"
                           href="{{ route('companies.invitations.history') }}"
                        >
                            Invitations envoyées
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(in_array(request()->route()->getName(), ['companies.profile.show', 'companies.profile.edit'])) active @endif"
                           href="{{ route('companies.profile.show') }}"
                        >
                            Profil
                        </a>
                    </li>
                @endif

                @if ($userRole === App\Enums\UserRole::Administrator)
                    <li class="nav-item">
                        <a
                            class="nav-link
                    {{ request()->routeIs('admin.home') ? 'active' : '' }}"
                            href="{{ route('admin.home') }}"
                        >
                            Tableau administrateur
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf

                        <button class="nav-link" type="submit">Se déconnecter</button>
                    </form>
                </li>
            @endauth
        </ul>
    </nav>
</div>
