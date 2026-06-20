@extends('layouts.dashboard')

@section('title', 'Administration Manager')

@section('content')
    <!-- Welcome Banner -->
    <div class="card border-0 text-white mb-4 rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #7c3aed, #4338ca);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="fw-bold mb-1">Console Administrateur : {{ Auth::user()->name }}</h3>
                    <p class="mb-0 opacity-75">Supervisez l'activité globale du portail, affectez des clients aux agents et générez les exports XML.</p>
                </div>
                <div class="col-auto d-none d-md-block">
                    <i class="bi bi-shield-lock display-4 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">Total Utilisateurs</p>
                    <h3 class="fw-bold mb-0">{{ \App\Models\User::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">Total Propriétés</p>
                    <h3 class="fw-bold text-primary mb-0">{{ \App\Models\Property::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">Affectations Actives</p>
                    <h3 class="fw-bold text-info mb-0">{{ \App\Models\ClientAgentAssignment::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">Exports XML</p>
                    <h3 class="fw-bold text-danger mb-0">{{ Auth::user()->xmlExports()->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="row g-4">
        <!-- XML Exports -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-filetype-xml text-danger me-2"></i>Historique des Exports XML</h5>
                    <a href="{{ route('manager.xml_export') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Nouvel Export</a>
                </div>
                <div class="card-body px-4">
                    @if(Auth::user()->xmlExports->isEmpty())
                        <p class="text-muted small">Aucun export XML généré.</p>
                    @else
                        @foreach(Auth::user()->xmlExports()->latest()->get() as $export)
                            <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                                <div class="text-truncate me-3">
                                    <p class="fw-semibold mb-0 small text-truncate">{{ basename($export->file_path) }}</p>
                                    <p class="text-muted mb-0" style="font-size: 0.7rem;">{{ $export->exported_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                                <span class="badge bg-success">Prêt</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Assignments -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-link-45deg text-info me-2"></i>Dernières affectations clients</h5>
                </div>
                <div class="card-body px-4">
                    @if(Auth::user()->managedAssignments->isEmpty())
                        <p class="text-muted small">Aucune affectation effectuée.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach(Auth::user()->managedAssignments()->with(['client', 'agent'])->latest()->take(5)->get() as $assignment)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold small">{{ $assignment->client->name }}</span>
                                            <span class="text-muted small mx-1">assigné à</span>
                                            <span class="fw-semibold small">{{ $assignment->agent->name }}</span>
                                        </div>
                                        <span class="text-muted" style="font-size: 0.7rem;">{{ $assignment->assigned_at->format('d/m/Y') }}</span>
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
