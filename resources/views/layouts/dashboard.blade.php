<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Espace d'administration ImmoManager">
    
    <title>@yield('title', 'Tableau de Bord') | ImmoManager</title>

    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/style.css') }}">

    @stack('styles')
</head>

<body>
    <div class="admin-shell">
        <div class="sidebar-backdrop" data-sidebar-close></div>

        <!-- Sidebar -->
        @include('partials.dashboard.sidebar')

        <div class="admin-main">
            <!-- Navbar -->
            @include('partials.dashboard.navbar')

            <main class="dashboard-content">
                <div class="container-fluid px-3 px-lg-4 py-4">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('partials.dashboard.footer')
        </div>
    </div>

    <script src="{{ asset('dashboard-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
