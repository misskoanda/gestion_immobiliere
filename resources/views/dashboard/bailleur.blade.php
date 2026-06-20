@extends('layouts.dashboard')

@section('title', 'Espace Bailleur')

@section('content')
    <!-- Welcome Banner -->
    <div class="card border-0 text-white mb-4 rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #f59e0b, #ea580c);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="fw-bold mb-1">Bienvenue, {{ Auth::user()->name }}</h3>
                    <p class="mb-0 opacity-75">Publiez vos annonces immobilières et suivez leur état de validation.</p>
                </div>
                <div class="col-auto d-none d-md-block">
                    <i class="bi bi-building display-4 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">Total Propriétés</p>
                    <h3 class="fw-bold mb-0">{{ Auth::user()->propertiesOwned()->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">Publiées</p>
                    <h3 class="fw-bold text-success mb-0">{{ Auth::user()->propertiesOwned()->where('status', 'publiee')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">En attente</p>
                    <h3 class="fw-bold text-warning mb-0">{{ Auth::user()->propertiesOwned()->where('status', 'en_attente')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-3">
                    <p class="text-muted mb-1 small">Refusées / Retirées</p>
                    <h3 class="fw-bold text-danger mb-0">{{ Auth::user()->propertiesOwned()->whereIn('status', ['refusee', 'retiree'])->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="fw-bold mb-0">Mes Propriétés Déposées</h5>
            <a href="{{ route('bailleur.properties.create') }}" class="btn btn-warning btn-sm rounded-pill px-3">
                <i class="bi bi-plus-circle me-1"></i>Ajouter un bien
            </a>
        </div>
        <div class="card-body p-0">
            @if(Auth::user()->propertiesOwned->isEmpty())
                <p class="text-muted p-4 mb-0">Vous n'avez pas encore déposé de biens immobiliers.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-uppercase text-muted fw-semibold">Titre</th>
                                <th class="small text-uppercase text-muted fw-semibold">Type</th>
                                <th class="small text-uppercase text-muted fw-semibold">Usage / Option</th>
                                <th class="small text-uppercase text-muted fw-semibold">Prix</th>
                                <th class="small text-uppercase text-muted fw-semibold">Statut</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date de dépôt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->propertiesOwned()->latest()->get() as $property)
                                <tr>
                                    <td class="fw-semibold">{{ $property->title }}</td>
                                    <td class="text-capitalize">{{ $property->type }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ ucfirst($property->usage) }}</span>
                                        <span class="badge {{ $property->option === 'vente' ? 'bg-danger' : 'bg-primary' }} bg-opacity-10 {{ $property->option === 'vente' ? 'text-danger' : 'text-primary' }}">{{ ucfirst($property->option) }}</span>
                                    </td>
                                    <td class="fw-bold">{{ number_format($property->price, 2) }} DT</td>
                                    <td>
                                        <span class="badge rounded-pill
                                            {{ $property->status === 'publiee' ? 'bg-success' :
                                               ($property->status === 'refusee' ? 'bg-danger' :
                                               ($property->status === 'retiree' ? 'bg-secondary' : 'bg-warning text-dark')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $property->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $property->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
