@extends('layouts.dashboard')

@section('title', 'Annonces à Valider')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-clock-history text-warning me-2"></i>Annonces en Attente de Validation</h4>
    </div>

    @php
        $pendingProperties = \App\Models\Property::where('status', 'en_attente')->with('owner')->latest()->paginate(10);
    @endphp

    @if($pendingProperties->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-check-circle display-1 text-success opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">Toutes les annonces sont traitées</h5>
                <p class="text-muted small">Aucune annonce en attente de validation.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-uppercase text-muted fw-semibold">Titre</th>
                                <th class="small text-uppercase text-muted fw-semibold">Bailleur</th>
                                <th class="small text-uppercase text-muted fw-semibold">Type / Option</th>
                                <th class="small text-uppercase text-muted fw-semibold">Prix</th>
                                <th class="small text-uppercase text-muted fw-semibold">Localisation</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date dépôt</th>
                                <th class="small text-uppercase text-muted fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingProperties as $property)
                                <tr>
                                    <td class="fw-semibold">{{ $property->title }}</td>
                                    <td class="small">{{ $property->owner->name }}</td>
                                    <td>
                                        <span class="text-capitalize small">{{ $property->type }}</span>
                                        <span class="badge {{ $property->option === 'vente' ? 'bg-danger' : 'bg-primary' }} bg-opacity-10 {{ $property->option === 'vente' ? 'text-danger' : 'text-primary' }} ms-1">{{ ucfirst($property->option) }}</span>
                                    </td>
                                    <td class="fw-bold small">{{ number_format($property->price, 2) }} DT</td>
                                    <td class="small text-muted">{{ $property->location }}</td>
                                    <td class="small text-muted">{{ $property->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <form action="{{ route('agent.properties.approve', $property) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success" title="Valider"><i class="bi bi-check-lg"></i></button>
                                            </form>
                                            <form action="{{ route('agent.properties.reject', $property) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger" title="Refuser"><i class="bi bi-x-lg"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $pendingProperties->links() }}</div>
    @endif
@endsection
