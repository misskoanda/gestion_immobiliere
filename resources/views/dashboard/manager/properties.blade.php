@extends('layouts.dashboard')

@section('title', 'Annonces Publiées')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-building text-primary me-2"></i>Gestion des Annonces Publiées</h4>
        <p class="text-muted small mb-0">Supervisez et retirez les annonces immobilières actuellement en ligne</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('manager.properties') }}" method="GET" class="row g-3">
                <div class="col-md-9">
                    <label for="search" class="form-label fw-semibold small text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="search" name="search" value="{{ request('search') }}" placeholder="Rechercher par titre, emplacement, type (ex: villa)...">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill">Rechercher</button>
                    <a href="{{ route('manager.properties') }}" class="btn btn-outline-secondary w-100 rounded-pill" title="Réinitialiser"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="small text-uppercase text-muted fw-semibold">#</th>
                            <th class="small text-uppercase text-muted fw-semibold">Titre</th>
                            <th class="small text-uppercase text-muted fw-semibold">Type / Usage</th>
                            <th class="small text-uppercase text-muted fw-semibold">Option</th>
                            <th class="small text-uppercase text-muted fw-semibold">Prix</th>
                            <th class="small text-uppercase text-muted fw-semibold">Localisation</th>
                            <th class="small text-uppercase text-muted fw-semibold">Propriétaire</th>
                            <th class="small text-uppercase text-muted fw-semibold">Agent</th>
                            <th class="small text-uppercase text-muted fw-semibold">Publié le</th>
                            <th class="small text-uppercase text-muted fw-semibold text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $p)
                            <tr>
                                <td class="text-muted small">{{ $p->id }}</td>
                                <td class="fw-semibold small">{{ $p->title }}</td>
                                <td class="small">
                                    <span class="text-capitalize">{{ $p->type }}</span>
                                    <span class="text-muted text-xs d-block">Usage: {{ $p->usage }}</span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $p->option === 'vente' ? 'bg-primary' : 'bg-info text-dark' }} text-capitalize">
                                        {{ $p->option }}
                                    </span>
                                </td>
                                <td class="fw-semibold text-primary small">
                                    {{ number_format($p->price, 0, ',', ' ') }} F CFA
                                    @if($p->area)
                                        <span class="text-muted text-xs d-block">{{ $p->area }} m²</span>
                                    @endif
                                </td>
                                <td class="small">{{ $p->location }}</td>
                                <td class="small">{{ $p->owner->name ?? '—' }}</td>
                                <td class="small">{{ $p->agent->name ?? '—' }}</td>
                                <td class="small text-muted">{{ $p->published_at ? $p->published_at->format('d/m/Y') : '—' }}</td>
                                <td class="text-end px-4">
                                    <form action="{{ route('manager.properties.withdraw', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cette annonce de la publication ?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Retirer l'annonce">
                                            <i class="bi bi-dash-circle me-1"></i>Retirer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">Aucune annonce publiée trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">{{ $properties->links() }}</div>
@endsection
