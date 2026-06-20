@extends('layouts.dashboard')

@section('title', 'Créer un Bailleur')

@section('content')
    <div class="mb-4">
        <a href="{{ route('manager.bailleurs') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mb-2">
            <i class="bi bi-arrow-left me-1"></i>Retour à la liste
        </a>
        <h4 class="fw-bold"><i class="bi bi-person-plus text-primary me-2"></i>Créer un Bailleur</h4>
    </div>

    <div class="card border-0 shadow-sm col-lg-8">
        <div class="card-body p-4">
            <form action="{{ route('manager.bailleurs.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold small text-muted">Nom complet du bailleur</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold small text-muted">Adresse Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold small text-muted">Téléphone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="is_active" class="form-label fw-semibold small text-muted">Statut du compte</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactif</option>
                        </select>
                        @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold small text-muted">Mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold small text-muted">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i>Créer le bailleur
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
