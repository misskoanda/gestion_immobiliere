<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ImmoManager - Votre plateforme de gestion et de recherche de biens immobiliers">

    <title>@yield('title', 'ImmoManager')</title>

    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ asset('front/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front/fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/fonts/themify-icons.css') }}">
    
    <!-- owl carousel Css-->
    <link rel="stylesheet" href="{{ asset('front/owlcarousel/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('front/owlcarousel/css/owl.theme.css') }}">
    
    <!-- jquery-simple-mobilemenu Css-->
    <link rel="stylesheet" href="{{ asset('front/css/jquery-simple-mobilemenu.css') }}">
    
    <!-- MAGNIFIC CSS -->
    <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}">
    
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{ asset('front/css/animate.css') }}">
    
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

    @stack('styles')
</head>

<body data-spy="scroll" data-offset="80">

    <!-- START PRELOADER -->
    <div class="preloaders">
        <span class="loader"></span>
    </div>
    <!-- END PRELOADER -->

    <!-- NAVBAR -->
    @include('partials.front.navbar')

    <!-- CONTENT -->
    @yield('content')

    <!-- FOOTER -->
    @include('partials.front.footer')

    <!-- Latest jQuery -->
    <script src="{{ asset('front/js/jquery-1.12.4.min.js') }}"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script src="{{ asset('front/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- modernizer JS -->
    <script src="{{ asset('front/js/modernizr-2.8.3.min.js') }}"></script>
    <!-- jquery-simple-mobilemenu.min -->
    <script src="{{ asset('front/js/jquery-simple-mobilemenu.js') }}"></script>
    <!-- owl-carousel min js  -->
    <script src="{{ asset('front/owlcarousel/js/owl.carousel.min.js') }}"></script>
    <!-- magnific-popup js -->
    <script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- countTo js -->
    <script src="{{ asset('front/js/jquery.inview.min.js') }}"></script>
    <!-- scrolltopcontrol js -->
    <script src="{{ asset('front/js/scrolltopcontrol.js') }}"></script>
    <!-- WOW - Reveal Animations When You Scroll -->
    <script src="{{ asset('front/js/wow.min.js') }}"></script>
    <!-- scripts js -->
    <script src="{{ asset('front/js/scripts.js') }}"></script>

    @stack('scripts')
</body>
</html>
