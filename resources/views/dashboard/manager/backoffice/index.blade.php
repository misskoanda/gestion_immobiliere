@extends('layouts.dashboard')

@section('title', 'Gestion Backoffice')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-shield-lock text-primary me-2"></i>Gestion Backoffice</h4>
            <p class="text-muted small mb-0">Gérez les comptes des agents et des managers</p>
        </div>
        <a href="{{ route('manager.backoffice.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i>Nouvel Utilisateur
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
            <form action="{{ route('manager.backoffice') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label fw-semibold small text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="search" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="role" class="form-label fw-semibold small text-muted">Rôle</label>
                    <select class="form-select" id="role" name="role">
                        <option value="">Tous les rôles</option>
                        <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
                        <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label fw-semibold small text-muted">Statut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill">Filtrer</button>
                    <a href="{{ route('manager.backoffice') }}" class="btn btn-outline-secondary w-100 rounded-pill" title="Réinitialiser"><i class="bi bi-arrow-clockwise"></i></a>
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
                            <th class="small text-uppercase text-muted fw-semibold">Rôle</th>
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
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td class="small">{{ $user->email }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $user->role === 'manager' ? 'bg-danger' : 'bg-success' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="small">{{ $user->phone ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 {{ $user->is_active ? 'text-success' : 'text-secondary' }}">
                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="small text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="text-end px-4">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('manager.backoffice.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if(Auth::id() !== $user->id)
                                            @if($user->is_active)
                                                <form action="{{ route('manager.users.deactivate', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Désactiver cet utilisateur ?')">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Désactiver"><i class="bi bi-pause-circle"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('manager.users.activate', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Activer cet utilisateur ?')">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Activer"><i class="bi bi-play-circle"></i></button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Aucun utilisateur backoffice trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
