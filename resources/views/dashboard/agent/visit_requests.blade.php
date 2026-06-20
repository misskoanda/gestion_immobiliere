@extends('layouts.dashboard')

@section('title', 'Demandes de Visite - Agent')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-envelope text-primary me-2"></i>Demandes de Visite</h4>
    </div>

    @if(Auth::user()->assignedVisitRequests->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-envelope-open display-1 text-muted opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">Aucune demande de visite</h5>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-uppercase text-muted fw-semibold">Client</th>
                                <th class="small text-uppercase text-muted fw-semibold">Propriété</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date souhaitée</th>
                                <th class="small text-uppercase text-muted fw-semibold">Message</th>
                                <th class="small text-uppercase text-muted fw-semibold">Statut</th>
                                <th class="small text-uppercase text-muted fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->assignedVisitRequests()->with(['client', 'property'])->latest()->paginate(10) as $request)
                                <tr>
                                    <td class="fw-semibold small">{{ $request->client->name }}</td>
                                    <td class="small">{{ $request->property->title ?? 'N/A' }}</td>
                                    <td class="small">{{ $request->requested_date ? $request->requested_date->format('d/m/Y H:i') : '—' }}</td>
                                    <td class="small text-muted text-truncate" style="max-width: 200px;">{{ $request->message ?? '—' }}</td>
                                    <td>
                                        <span class="badge rounded-pill
                                            {{ $request->status === 'validee' ? 'bg-success' : ($request->status === 'refusee' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($request->status === 'en_attente')
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('agent.visit_requests.approve', $request) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Valider"><i class="bi bi-check-lg"></i></button>
                                                </form>
                                                <form action="{{ route('agent.visit_requests.reject', $request) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger" title="Refuser"><i class="bi bi-x-lg"></i></button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">Traité</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
