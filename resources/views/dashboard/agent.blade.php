@extends('layouts.dashboard')

@section('title', 'Portail Agent')

@section('content')
    <!-- Welcome Banner -->
    <div class="card border-0 text-white mb-4 rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #10b981, #0d9488);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="fw-bold mb-1">Espace Agent : {{ Auth::user()->name }}</h3>
                    <p class="mb-0 opacity-75">Traitez les demandes de visites et gérez l'approbation des annonces de biens.</p>
                </div>
                <div class="col-auto d-none d-md-block">
                    <i class="bi bi-person-workspace display-4 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                        <i class="bi bi-people-fill text-info fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Clients affectés</p>
                        <h4 class="fw-bold mb-0">{{ Auth::user()->agentAssignments()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="bi bi-envelope-open text-primary fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Demandes de visite</p>
                        <h4 class="fw-bold mb-0">{{ Auth::user()->assignedVisitRequests()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="bi bi-building-check text-success fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Biens sous gestion</p>
                        <h4 class="fw-bold mb-0">{{ Auth::user()->propertiesManaged()->count() }}</h4>
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
                    <h5 class="fw-bold mb-0"><i class="bi bi-envelope text-primary me-2"></i>Demandes de visites à traiter</h5>
                </div>
                <div class="card-body px-4">
                    @if(Auth::user()->assignedVisitRequests->isEmpty())
                        <p class="text-muted small">Aucune demande de visite assignée pour le moment.</p>
                    @else
                        @foreach(Auth::user()->assignedVisitRequests()->with(['client', 'property'])->latest()->take(5)->get() as $request)
                            <div class="border rounded-3 p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small"><i class="bi bi-person me-1"></i>{{ $request->client->name }}</span>
                                    <span class="badge rounded-pill
                                        {{ $request->status === 'validee' ? 'bg-success' : ($request->status === 'refusee' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                                <h6 class="fw-semibold mb-1 small">{{ $request->property->title ?? 'N/A' }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.75rem;">
                                    <i class="bi bi-clock me-1"></i>{{ $request->requested_date ? $request->requested_date->format('d/m/Y H:i') : 'Non spécifiée' }}
                                </p>
                                @if($request->message)
                                    <div class="mt-2 p-2 bg-light rounded small fst-italic">
                                        "{{ $request->message }}"
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Assigned Clients -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-people text-info me-2"></i>Mes Clients Affectés</h5>
                </div>
                <div class="card-body px-4">
                    @if(Auth::user()->agentAssignments->isEmpty())
                        <p class="text-muted small">Aucun client ne vous est actuellement affecté.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach(Auth::user()->agentAssignments()->with('client')->latest()->get() as $assignment)
                                <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="fw-semibold mb-0 small">{{ $assignment->client->name }}</p>
                                        <p class="text-muted mb-0" style="font-size: 0.75rem;">{{ $assignment->client->email }}</p>
                                    </div>
                                    <span class="text-muted" style="font-size: 0.7rem;">{{ $assignment->assigned_at->format('d/m/Y') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
