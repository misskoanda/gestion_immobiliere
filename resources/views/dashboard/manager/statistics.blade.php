@extends('layouts.dashboard')

@section('title', 'Statistiques')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-bar-chart-line text-primary me-2"></i>Statistiques Globales</h4>
    </div>

    @php
        $totalUsers = \App\Models\User::count();
        $totalClients = \App\Models\User::where('role', 'client')->count();
        $totalBailleurs = \App\Models\User::where('role', 'bailleur')->count();
        $totalAgents = \App\Models\User::where('role', 'agent')->count();
        $totalProperties = \App\Models\Property::count();
        $publishedProperties = \App\Models\Property::where('status', 'publiee')->count();
        $pendingProperties = \App\Models\Property::where('status', 'en_attente')->count();
        $totalVisitRequests = \App\Models\VisitRequest::count();
        $pendingVisits = \App\Models\VisitRequest::where('status', 'en_attente')->count();
        $totalAssignments = \App\Models\ClientAgentAssignment::count();
    @endphp

    <!-- Users Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-4">
                    <i class="bi bi-people-fill display-5 text-primary opacity-50 mb-2 d-block"></i>
                    <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                    <p class="text-muted mb-0 small">Utilisateurs Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-4">
                    <i class="bi bi-person display-5 text-info opacity-50 mb-2 d-block"></i>
                    <h3 class="fw-bold mb-0">{{ $totalClients }}</h3>
                    <p class="text-muted mb-0 small">Clients</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-4">
                    <i class="bi bi-building display-5 text-warning opacity-50 mb-2 d-block"></i>
                    <h3 class="fw-bold mb-0">{{ $totalBailleurs }}</h3>
                    <p class="text-muted mb-0 small">Bailleurs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-4">
                    <i class="bi bi-person-workspace display-5 text-success opacity-50 mb-2 d-block"></i>
                    <h3 class="fw-bold mb-0">{{ $totalAgents }}</h3>
                    <p class="text-muted mb-0 small">Agents</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties & Activity Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-houses text-primary me-2"></i>Propriétés</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Total</span>
                            <span class="fw-bold">{{ $totalProperties }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Publiées</span>
                            <span class="badge bg-success rounded-pill">{{ $publishedProperties }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">En attente</span>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $pendingProperties }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-calendar-check text-info me-2"></i>Demandes de visite</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Total</span>
                            <span class="fw-bold">{{ $totalVisitRequests }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">En attente</span>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $pendingVisits }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-link-45deg text-danger me-2"></i>Affectations</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Affectations actives</span>
                            <span class="fw-bold">{{ $totalAssignments }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
