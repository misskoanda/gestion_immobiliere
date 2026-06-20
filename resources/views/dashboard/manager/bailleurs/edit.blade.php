@extends('layouts.dashboard')

@section('title', 'Modifier le Bailleur')

@section('content')
    <div class="mb-4">
        <a href="{{ route('manager.bailleurs') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mb-2">
            <i class="bi bi-arrow-left me-1"></i>Retour à la liste
        </a>
        <h4 class="fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Modifier le Bailleur</h4>
    </div>

    <div class="card border-0 shadow-sm col-lg-8">
        <div class="card-body p-4">
            <form action="{{ route('manager.bailleurs.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold small text-muted">Nom complet du bailleur</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold small text-muted">Adresse Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold small text-muted">Téléphone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="is_active" class="form-label fw-semibold small text-muted">Statut du compte</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Inactif</option>
                        </select>
                        @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="alert alert-info border-0 py-2 small mb-0">
                            <i class="bi bi-info-circle me-1"></i>Laissez les champs mot de passe vides si vous ne souhaitez pas les modifier.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold small text-muted">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold small text-muted">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
