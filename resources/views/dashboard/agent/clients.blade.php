@extends('layouts.dashboard')

@section('title', 'Clients Affectés')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-people text-info me-2"></i>Mes Clients Affectés</h4>
    </div>

    @if(Auth::user()->agentAssignments->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-people display-1 text-muted opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">Aucun client affecté</h5>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-uppercase text-muted fw-semibold">Nom</th>
                                <th class="small text-uppercase text-muted fw-semibold">Email</th>
                                <th class="small text-uppercase text-muted fw-semibold">Téléphone</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date d'affectation</th>
                                <th class="small text-uppercase text-muted fw-semibold">Demandes de visite</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->agentAssignments()->with('client')->latest()->get() as $assignment)
                                <tr>
                                    <td class="fw-semibold">{{ $assignment->client->name }}</td>
                                    <td class="small">{{ $assignment->client->email }}</td>
                                    <td class="small">{{ $assignment->client->phone ?? '—' }}</td>
                                    <td class="small text-muted">{{ $assignment->assigned_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $assignment->client->visitRequests()->count() }}
                                        </span>
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
