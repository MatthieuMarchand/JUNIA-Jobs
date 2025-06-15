<header>
    <a href="{{  route('home') }}">
        <img src="{{ asset('images/logos/junia_jobs.svg') }}" alt="Logo JUNIA Jobs">
    </a>

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
