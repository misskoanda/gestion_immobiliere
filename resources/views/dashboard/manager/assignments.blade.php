@extends('layouts.dashboard')

@section('title', 'Affectations Clients-Agents')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-link-45deg text-info me-2"></i>Affectations Clients → Agents</h4>
    </div>

    <!-- New Assignment Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Nouvelle Affectation</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('manager.assignments.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="client_id" class="form-label fw-semibold small">Client</label>
                        <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                            <option value="">Sélectionner un client...</option>
                            @foreach(\App\Models\User::where('role', 'client')->orderBy('name')->get() as $client)
                                <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                            @endforeach
                        </select>
                        @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="agent_id" class="form-label fw-semibold small">Agent</label>
                        <select class="form-select @error('agent_id') is-invalid @enderror" id="agent_id" name="agent_id" required>
                            <option value="">Sélectionner un agent...</option>
                            @foreach(\App\Models\User::where('role', 'agent')->orderBy('name')->get() as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->email }})</option>
                            @endforeach
                        </select>
                        @error('agent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 w-100">
                            <i class="bi bi-link me-1"></i>Affecter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Existing Assignments -->
    @php
        $assignments = \App\Models\ClientAgentAssignment::with(['client', 'agent', 'manager'])->latest()->paginate(15);
    @endphp

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Affectations Actives ({{ $assignments->total() }})</h6>
        </div>
        <div class="card-body p-0">
            @if($assignments->isEmpty())
                <p class="text-muted p-4 mb-0">Aucune affectation.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-uppercase text-muted fw-semibold">Client</th>
                                <th class="small text-uppercase text-muted fw-semibold">Agent</th>
                                <th class="small text-uppercase text-muted fw-semibold">Affecté par</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date</th>
                                <th class="small text-uppercase text-muted fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignments as $a)
                                <tr>
                                    <td class="fw-semibold small">{{ $a->client->name }}</td>
                                    <td class="small">{{ $a->agent->name }}</td>
                                    <td class="small text-muted">{{ $a->manager->name ?? '—' }}</td>
                                    <td class="small text-muted">{{ $a->assigned_at->format('d/m/Y') }}</td>
                                    <td>
                                        <form action="{{ route('manager.assignments.destroy', $a) }}" method="POST" onsubmit="return confirm('Supprimer cette affectation ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">{{ $assignments->links() }}</div>
@endsection
