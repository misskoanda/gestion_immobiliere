@extends('layouts.dashboard')

@section('title', 'Tableau de Bord Client')

@section('content')
    <!-- Welcome Banner -->
    <div class="card border-0 bg-primary text-white mb-4 rounded-3 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="fw-bold mb-1">Ravi de vous revoir, {{ Auth::user()->name }} !</h3>
                    <p class="mb-0 opacity-75">Recherchez des propriétés, gérez vos favoris et suivez vos demandes de visite.</p>
                </div>
                <div class="col-auto d-none d-md-block">
                    <i class="bi bi-house-heart display-4 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                        <i class="bi bi-heart-fill text-danger fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Mes Favoris</p>
                        <h4 class="fw-bold mb-0">{{ Auth::user()->favorites()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="bi bi-calendar-check text-primary fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Demandes de visite</p>
                        <h4 class="fw-bold mb-0">{{ Auth::user()->visitRequests()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="bi bi-person-badge text-success fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Mon Agent Dédié</p>
                        <h5 class="fw-bold mb-0">
                            {{ Auth::user()->clientAssignment ? Auth::user()->clientAssignment->agent->name : 'Non assigné' }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="row g-4">
        <!-- Visit Requests -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-calendar3 text-primary me-2"></i>Demandes de Visites Récentes</h5>
                </div>
                <div class="card-body px-4">
                    @if(Auth::user()->visitRequests->isEmpty())
                        <p class="text-muted small">Vous n'avez pas encore envoyé de demandes de visite.</p>
                    @else
                        @foreach(Auth::user()->visitRequests()->with('property')->latest()->take(5)->get() as $request)
                            <div class="border rounded-3 p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-semibold mb-0 small">{{ $request->property->title ?? 'N/A' }}</h6>
                                    <span class="badge rounded-pill
                                        {{ $request->status === 'validee' ? 'bg-success' : ($request->status === 'refusee' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 0.75rem;">
                                    <i class="bi bi-clock me-1"></i>
                                    Date demandée : {{ $request->requested_date ? $request->requested_date->format('d/m/Y H:i') : 'Non spécifiée' }}
                                </p>
                                @if($request->agent_response)
                                    <div class="mt-2 p-2 bg-light rounded small">
                                        <strong>Réponse de l'agent :</strong> {{ $request->agent_response }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Favorites -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-heart text-danger me-2"></i>Mes Favoris Récents</h5>
                </div>
                <div class="card-body px-4">
                    @if(Auth::user()->favoriteProperties->isEmpty())
                        <p class="text-muted small">Vous n'avez pas encore ajouté de propriétés à vos favoris.</p>
                    @else
                        <div class="row g-3">
                            @foreach(Auth::user()->favoriteProperties()->latest()->take(4)->get() as $property)
                                <div class="col-sm-6">
                                    <div class="border rounded-3 p-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2 text-uppercase small">{{ $property->type }}</span>
                                        <h6 class="fw-bold mb-1 text-truncate">{{ $property->title }}</h6>
                                        <p class="text-muted mb-2" style="font-size: 0.75rem;">{{ $property->location }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-primary small">{{ number_format($property->price, 2) }} DT</span>
                                            <span class="badge bg-light text-dark">{{ ucfirst($property->option) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
