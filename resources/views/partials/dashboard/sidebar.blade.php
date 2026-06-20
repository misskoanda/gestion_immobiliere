<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
  <div class="sidebar-header">
    <a class="brand-mark" href="{{ route('dashboard') }}" aria-label="ImmoGestion dashboard">
      <span class="brand-icon"><i class="bi bi-houses-fill" aria-hidden="true"></i></span>
      <span class="brand-copy">
        <span class="brand-title">ImmoGestion</span>
        <span class="brand-subtitle">Espace {{ ucfirst(Auth::user()->role) }}</span>
      </span>
    </a>
  </div>

  <nav class="sidebar-nav">
    @if(Auth::user()->role === 'client')
      <a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}" href="{{ route('client.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Tableau de bord</span>
      </a>
      <a class="nav-link" href="{{ route('properties.index') }}">
        <span class="nav-icon"><i class="bi bi-search" aria-hidden="true"></i></span>
        <span class="nav-text">Propriétés</span>
      </a>
      <a class="nav-link {{ request()->routeIs('client.favorites') ? 'active' : '' }}" href="{{ route('client.favorites') }}">
        <span class="nav-icon"><i class="bi bi-heart" aria-hidden="true"></i></span>
        <span class="nav-text">Favoris</span>
      </a>
      <a class="nav-link {{ request()->routeIs('client.visit_requests') ? 'active' : '' }}" href="{{ route('client.visit_requests') }}">
        <span class="nav-icon"><i class="bi bi-calendar-check" aria-hidden="true"></i></span>
        <span class="nav-text">Demandes de visite</span>
      </a>

    @elseif(Auth::user()->role === 'bailleur')
      <a class="nav-link {{ request()->routeIs('bailleur.dashboard') ? 'active' : '' }}" href="{{ route('bailleur.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Tableau de bord</span>
      </a>
      <a class="nav-link {{ request()->routeIs('bailleur.properties') ? 'active' : '' }}" href="{{ route('bailleur.properties') }}">
        <span class="nav-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <span class="nav-text">Mes annonces</span>
      </a>
      <a class="nav-link" href="#" onclick="alert('Fonctionnalité d\'ajout d\'annonce à intégrer');">
        <span class="nav-icon"><i class="bi bi-plus-circle" aria-hidden="true"></i></span>
        <span class="nav-text">Ajouter une annonce</span>
      </a>

    @elseif(Auth::user()->role === 'agent')
      <a class="nav-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}" href="{{ route('agent.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Tableau de bord</span>
      </a>
      <a class="nav-link {{ request()->routeIs('agent.properties_pending') ? 'active' : '' }}" href="{{ route('agent.properties_pending') }}">
        <span class="nav-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
        <span class="nav-text">Annonces à valider</span>
      </a>
      <a class="nav-link {{ request()->routeIs('agent.visit_requests') ? 'active' : '' }}" href="{{ route('agent.visit_requests') }}">
        <span class="nav-icon"><i class="bi bi-envelope" aria-hidden="true"></i></span>
        <span class="nav-text">Demandes de visite</span>
      </a>
      <a class="nav-link {{ request()->routeIs('agent.clients') ? 'active' : '' }}" href="{{ route('agent.clients') }}">
        <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        <span class="nav-text">Clients affectés</span>
      </a>

    @elseif(Auth::user()->role === 'manager')
      <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Tableau de bord</span>
      </a>
      <a class="nav-link {{ request()->routeIs('manager.backoffice*') ? 'active' : '' }}" href="{{ route('manager.backoffice') }}">
        <span class="nav-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
        <span class="nav-text">Backoffice</span>
      </a>
      <a class="nav-link {{ request()->routeIs('manager.clients*') ? 'active' : '' }}" href="{{ route('manager.clients') }}">
        <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        <span class="nav-text">Clients</span>
      </a>
      <a class="nav-link {{ request()->routeIs('manager.bailleurs*') ? 'active' : '' }}" href="{{ route('manager.bailleurs') }}">
        <span class="nav-icon"><i class="bi bi-person-workspace" aria-hidden="true"></i></span>
        <span class="nav-text">Bailleurs</span>
      </a>
      <a class="nav-link {{ request()->routeIs('manager.properties*') ? 'active' : '' }}" href="{{ route('manager.properties') }}">
        <span class="nav-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <span class="nav-text">Annonces publiées</span>
      </a>
      <a class="nav-link {{ request()->routeIs('manager.assignments') ? 'active' : '' }}" href="{{ route('manager.assignments') }}">
        <span class="nav-icon"><i class="bi bi-link-45deg" aria-hidden="true"></i></span>
        <span class="nav-text">Affectations</span>
      </a>
      <a class="nav-link {{ request()->routeIs('manager.statistics') ? 'active' : '' }}" href="{{ route('manager.statistics') }}">
        <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
        <span class="nav-text">Statistiques</span>
      </a>
      <a class="nav-link {{ request()->routeIs('manager.xml_export') ? 'active' : '' }}" href="{{ route('manager.xml_export') }}">
        <span class="nav-icon"><i class="bi bi-filetype-xml" aria-hidden="true"></i></span>
        <span class="nav-text">Export XML</span>
      </a>
    @endif
  </nav>

  <div class="sidebar-user">
    <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('dashboard-assets/images/avatar/avatar.jpg') }}" alt="{{ Auth::user()->name }}">
    <strong>{{ Auth::user()->name }}</strong>
    <small>Rôle : {{ ucfirst(Auth::user()->role) }}</small>
  </div>

  <div class="sidebar-footer">
    <span class="status-dot"></span>
    <span class="sidebar-footer-text">Système en ligne</span>
  </div>
</aside>
