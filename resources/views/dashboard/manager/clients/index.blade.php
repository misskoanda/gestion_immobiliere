@extends('layouts.dashboard')

@section('title', 'Gestion des Clients')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-people text-primary me-2"></i>Gestion des Clients</h4>
            <p class="text-muted small mb-0">Validez les inscriptions et gérez les comptes clients</p>
        </div>
        <a href="{{ route('manager.clients.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i>Nouveau Client
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('manager.clients') }}" method="GET" class="row g-3">
                <div class="col-md-7">
                    <label for="search" class="form-label fw-semibold small text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="search" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone du client...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold small text-muted">Statut de validation</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Validé (Actif)</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>En attente de validation (Inactif)</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill">Filtrer</button>
                    <a href="{{ route('manager.clients') }}" class="btn btn-outline-secondary w-100 rounded-pill" title="Réinitialiser"><i class="bi bi-arrow-clockwise"></i></a>
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
                            <th class="small text-uppercase text-muted fw-semibold">Nom</th>
                            <th class="small text-uppercase text-muted fw-semibold">Email</th>
                            <th class="small text-uppercase text-muted fw-semibold">Téléphone</th>
                            <th class="small text-uppercase text-muted fw-semibold">Statut</th>
                            <th class="small text-uppercase text-muted fw-semibold">Inscription</th>
                            <th class="small text-uppercase text-muted fw-semibold text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-muted small">{{ $user->id }}</td>
                                <td class="fw-semibold">
                                    {{ $user->name }}
                                    @if(!$user->is_active)
                                        <span class="badge bg-warning text-dark ms-1 small" style="font-size: 0.7rem;">Nouveau</span>
                                    @endif
                                </td>
                                <td class="small">{{ $user->email }}</td>
                                <td class="small">{{ $user->phone ?? '—' }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>Validé (Actif)
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning">
                                            <i class="bi bi-clock-fill me-1"></i>En attente (Inactif)
                                        </span>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="text-end px-4">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('manager.clients.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if($user->is_active)
                                            <form action="{{ route('manager.users.deactivate', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Désactiver le compte de ce client ?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Désactiver / Invalider"><i class="bi bi-pause-circle"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('manager.users.activate', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Valider et activer le compte de ce client ?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" title="Valider / Activer"><i class="bi bi-check-lg me-1"></i>Valider</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Aucun client trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
