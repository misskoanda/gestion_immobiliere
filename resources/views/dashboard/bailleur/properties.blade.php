@extends('layouts.dashboard')

@section('title', 'Mes Annonces')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-building text-warning me-2"></i>Mes Annonces</h4>
        <a href="{{ route('bailleur.properties.create') }}" class="btn btn-warning btn-sm rounded-pill px-3">
            <i class="bi bi-plus-circle me-1"></i>Nouvelle annonce
        </a>
    </div>

    @if(Auth::user()->propertiesOwned->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-building display-1 text-muted opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">Aucune annonce déposée</h5>
                <p class="text-muted small">Commencez par ajouter votre premier bien immobilier.</p>
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
                                <th class="small text-uppercase text-muted fw-semibold">Type</th>
                                <th class="small text-uppercase text-muted fw-semibold">Option</th>
                                <th class="small text-uppercase text-muted fw-semibold">Prix</th>
                                <th class="small text-uppercase text-muted fw-semibold">Statut</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date</th>
                                <th class="small text-uppercase text-muted fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->propertiesOwned()->latest()->paginate(10) as $property)
                                <tr>
                                    <td class="fw-semibold">{{ $property->title }}</td>
                                    <td class="text-capitalize small">{{ $property->type }}</td>
                                    <td>
                                        <span class="badge {{ $property->option === 'vente' ? 'bg-danger' : 'bg-primary' }} bg-opacity-10 {{ $property->option === 'vente' ? 'text-danger' : 'text-primary' }}">{{ ucfirst($property->option) }}</span>
                                    </td>
                                    <td class="fw-bold small">{{ number_format($property->price, 2) }} FCFA</td>
                                    <td>
                                        <span class="badge rounded-pill
                                            {{ $property->status === 'publiee' ? 'bg-success' :
                                               ($property->status === 'refusee' ? 'bg-danger' :
                                               ($property->status === 'retiree' ? 'bg-secondary' : 'bg-warning text-dark')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $property->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $property->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('bailleur.properties.edit', $property) }}" class="btn btn-outline-secondary" title="Modifier"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('bailleur.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
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
        <div class="mt-4">
            {{ Auth::user()->propertiesOwned()->latest()->paginate(10)->links() }}
        </div>
    @endif
@endsection
