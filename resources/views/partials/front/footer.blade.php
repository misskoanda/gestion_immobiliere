<!-- START FOOTER -->
<div class="footer section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <a href="{{ route('home') }}"><img src="{{ asset('front/img/logo.png') }}" alt="Logo"></a>
                    <p>Votre partenaire de confiance pour la recherche et la gestion de vos biens immobiliers. Simplifiez vos démarches de location, vente et acquisition.</p>
                    <div class="social_profile">
                        <ul>
                            <li><a class="f_facebook" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a class="f_instagram" href="#"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a class="f_linkedin" href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div><!--- END COL -->
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Notre Système</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('properties.index') }}">Propriétés</a></li>
                        <li><a href="{{ route('login') }}">Se connecter</a></li>
                        <li><a href="{{ route('register') }}">S'inscrire</a></li>
                    </ul>
                </div>
            </div><!--- END COL -->
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Catégories Mobiles</h4>
                    <ul>
                        <li><a href="{{ route('properties.index') }}?type=villa">Villas</a></li>
                        <li><a href="{{ route('properties.index') }}?type=appartement">Appartements</a></li>
                        <li><a href="{{ route('properties.index') }}?type=terrain">Terrains</a></li>
                        <li><a href="{{ route('properties.index') }}?type=commerce">Commerces</a></li>
                    </ul>
                </div>
            </div><!--- END COL -->
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Contact Info</h4>
                    <div class="sf_contact">
                        <span class="ti-map"></span>
                        <p>Avenue Habib Bourguiba, Tunis, Tunisie</p>
                    </div>
                    <div class="sf_contact">
                        <span class="ti-mobile"></span>
                        <p>+216 71 000 000</p>
                    </div>
                    <div class="sf_contact">
                        <span class="ti-email"></span>
                        <p>contact@immo-gestion.com</p>
                    </div>
                </div>
            </div><!--- END COL -->
        </div><!--- END ROW -->
    </div><!--- END CONTAINER -->
</div>
<!-- END FOOTER -->

<!-- START FOOTER COPYRIGHT -->
<div class="foot_copy">
    <div class="footer_copyright">
        <p>&copy; {{ date('Y') }}. Tous droits réservés • Distribué par <a href="#">ThemeWagon</a></p>
    </div>
</div>
<!-- END FOOTER COPYRIGHT -->
