<!-- START NAVBAR -->
<div id="navigation" class="navbar-light bg-faded site-navigation">
    <div class="container-fluid">
        <div class="row">
            <div class="col-20 align-self-center">
                <div class="site-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('front/img/logo1.jpeg') }}" alt="ImmoManager"></a>
                </div>
            </div><!--- END Col -->

            <div class="col-60 d-flex" style="justify-content: center; align-items: center;">
                <nav id="main-menu">
                    <ul>
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('properties.index') }}">Propriétés</a></li>
                    </ul>
                </nav>
            </div><!--- END Col -->

            <div class="col-20 d-none d-xl-flex text-end align-self-center">
                @guest
                    <a href="{{ route('login') }}" class="header-btn">Connexion</a>
                    <a href="{{ route('register') }}" class="btn_one">Inscription</a>
                @else
                    <a href="{{ route('dashboard') }}" class="header-btn">Mon Espace</a>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                        @csrf
                    </form>
                    <a href="#" class="btn_one" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
                @endguest
            </div><!--- END Col -->

            <ul class="mobile_menu">
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('properties.index') }}">Propriétés</a></li>
                @guest
                    <li><a href="{{ route('login') }}" style="display:flex;align-items:center;justify-content:center;">Connexion</a></li>
                    <li><a href="{{ route('register') }}">Inscription</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}" style="display:flex;align-items:center;justify-content:center;">Mon Espace</a></li>
                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a></li>
                @endguest
            </ul>
        </div><!--- END ROW -->
    </div><!--- END CONTAINER -->
</div>
<!-- END NAVBAR -->
