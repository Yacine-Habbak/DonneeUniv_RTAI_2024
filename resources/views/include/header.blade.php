<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('accueil') }}">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo">
            </a>
            <!-- Bouton du menu hamburger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Contenu du menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-5">
                        <a class="nav-link {{ request()->routeIs('accueil') ? 'active-lien' : '' }}" href="{{ route('accueil') }}">Accueil</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link {{ request()->routeIs('etablissements.all') ? 'active-lien' : '' }}" href="{{ route('etablissements.all') }}">Liste des établissements</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link {{ request()->routeIs('disciplines.all') ? 'active-lien' : '' }}" href="{{ route('disciplines.all') }}">Liste des disciplines</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link {{ request()->routeIs('statistiques.index') ? 'active-lien' : '' }}" href="{{ route('statistiques.index') }}">Statistiques</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>