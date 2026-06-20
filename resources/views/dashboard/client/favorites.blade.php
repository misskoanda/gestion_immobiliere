@extends('layouts.dashboard')

@section('title', 'Mes Favoris')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-heart-fill text-danger me-2"></i>Mes Favoris</h4>
        <a href="{{ route('properties.index') }}" class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-search me-1"></i>Explorer les propriétés
        </a>
    </div>

    @if(Auth::user()->favoriteProperties->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-heart display-1 text-muted opacity-25 mb-3 d-block"></i>
                <h5 class="text-muted">Aucun favori pour le moment</h5>
                <p class="text-muted small">Explorez les propriétés disponibles et ajoutez-les à vos favoris.</p>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach(Auth::user()->favoriteProperties()->latest()->paginate(12) as $property)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge {{ $property->option === 'vente' ? 'bg-danger' : 'bg-primary' }} bg-opacity-10 {{ $property->option === 'vente' ? 'text-danger' : 'text-primary' }} text-uppercase small">{{ $property->option }}</span>
                                <button class="btn btn-sm btn-outline-danger rounded-circle" title="Retirer des favoris">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </div>
                            <h6 class="fw-bold text-truncate">{{ $property->title }}</h6>
                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $property->location }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">{{ number_format($property->price, 2) }} DT</span>
                                <span class="badge bg-light text-dark">{{ ucfirst($property->type) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ Auth::user()->favoriteProperties()->latest()->paginate(12)->links() }}
        </div>
    @endif
@endsection
