@extends('layouts.dashboard')

@section('title', 'Ajouter une Propriété')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-plus-circle text-warning me-2"></i>Ajouter un nouveau bien</h4>
        <p class="text-muted small">Remplissez les informations de votre bien immobilier.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('bailleur.properties.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-12">
                        <label for="title" class="form-label fw-semibold">Titre de l'annonce <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="type" class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Choisir...</option>
                            <option value="appartement" {{ old('type') === 'appartement' ? 'selected' : '' }}>Appartement</option>
                            <option value="villa" {{ old('type') === 'villa' ? 'selected' : '' }}>Villa</option>
                            <option value="terrain" {{ old('type') === 'terrain' ? 'selected' : '' }}>Terrain</option>
                            <option value="batiment" {{ old('type') === 'batiment' ? 'selected' : '' }}>Bâtiment</option>
                            <option value="commerce" {{ old('type') === 'commerce' ? 'selected' : '' }}>Commerce / Local Commercial</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="usage" class="form-label fw-semibold">Usage <span class="text-danger">*</span></label>
                        <select class="form-select @error('usage') is-invalid @enderror" id="usage" name="usage" required>
                            <option value="">Choisir...</option>
                            <option value="residence" {{ old('usage') === 'residence' ? 'selected' : '' }}>Habitation / Résidence</option>
                            <option value="bureau" {{ old('usage') === 'bureau' ? 'selected' : '' }}>Bureau / Professionnel</option>
                            <option value="commerce" {{ old('usage') === 'commerce' ? 'selected' : '' }}>Commercial</option>
                            <option value="agriculture" {{ old('usage') === 'agriculture' ? 'selected' : '' }}>Agricole</option>
                        </select>
                        @error('usage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="option" class="form-label fw-semibold">Option <span class="text-danger">*</span></label>
                        <select class="form-select @error('option') is-invalid @enderror" id="option" name="option" required>
                            <option value="">Choisir...</option>
                            <option value="location" {{ old('option') === 'location' ? 'selected' : '' }}>Location</option>
                            <option value="vente" {{ old('option') === 'vente' ? 'selected' : '' }}>Vente</option>
                        </select>
                        @error('option') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="location" class="form-label fw-semibold">Localisation <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="area" class="form-label fw-semibold">Superficie (m²)</label>
                        <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area') }}">
                        @error('area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="price" class="form-label fw-semibold">Prix (DT) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="photos" class="form-label fw-semibold">Photos</label>
                        <input type="file" class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror" id="photos" name="photos[]" multiple accept="image/*">
                        <div class="form-text">Vous pouvez sélectionner plusieurs images.</div>
                        @error('photos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @error('photos.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-check-circle me-1"></i>Déposer l'annonce
                    </button>
                    <a href="{{ route('bailleur.properties') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
