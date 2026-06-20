@extends('layouts.dashboard')

@section('title', 'Mes Demandes de Visite')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-calendar-check text-primary me-2"></i>Mes Demandes de Visite</h4>
    </div>

    @if(Auth::user()->visitRequests->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">Aucune demande de visite</h5>
                <p class="text-muted small">Vous n'avez pas encore envoyé de demandes de visite.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-uppercase text-muted fw-semibold">Propriété</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date demandée</th>
                                <th class="small text-uppercase text-muted fw-semibold">Statut</th>
                                <th class="small text-uppercase text-muted fw-semibold">Agent</th>
                                <th class="small text-uppercase text-muted fw-semibold">Réponse</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->visitRequests()->with(['property', 'agent'])->latest()->paginate(10) as $request)
                                <tr>
                                    <td class="fw-semibold">{{ $request->property->title ?? 'N/A' }}</td>
                                    <td class="small">{{ $request->requested_date ? $request->requested_date->format('d/m/Y H:i') : 'Non spécifiée' }}</td>
                                    <td>
                                        <span class="badge rounded-pill
                                            {{ $request->status === 'validee' ? 'bg-success' : ($request->status === 'refusee' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="small">{{ $request->agent->name ?? 'Non assigné' }}</td>
                                    <td class="small text-muted">{{ $request->agent_response ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ Auth::user()->visitRequests()->with(['property', 'agent'])->latest()->paginate(10)->links() }}
        </div>
    @endif
@endsection
