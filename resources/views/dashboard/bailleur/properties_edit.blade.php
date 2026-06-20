@extends('layouts.dashboard')

@section('title', 'Modifier la Propriété')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-pencil-square text-warning me-2"></i>Modifier le bien : {{ $property->title }}</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('bailleur.properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row g-3">
                    <div class="col-12">
                        <label for="title" class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $property->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="type" class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            @foreach([
                                'appartement' => 'Appartement',
                                'villa' => 'Villa',
                                'terrain' => 'Terrain',
                                'batiment' => 'Bâtiment',
                                'commerce' => 'Commerce / Local Commercial'
                            ] as $value => $label)
                                <option value="{{ $value }}" {{ old('type', $property->type) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="usage" class="form-label fw-semibold">Usage <span class="text-danger">*</span></label>
                        <select class="form-select @error('usage') is-invalid @enderror" id="usage" name="usage" required>
                            @foreach([
                                'residence' => 'Habitation / Résidence',
                                'bureau' => 'Bureau / Professionnel',
                                'commerce' => 'Commercial',
                                'agriculture' => 'Agricole'
                            ] as $value => $label)
                                <option value="{{ $value }}" {{ old('usage', $property->usage) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('usage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="option" class="form-label fw-semibold">Option <span class="text-danger">*</span></label>
                        <select class="form-select @error('option') is-invalid @enderror" id="option" name="option" required>
                            @foreach(['location', 'vente'] as $o)
                                <option value="{{ $o }}" {{ old('option', $property->option) === $o ? 'selected' : '' }}>{{ ucfirst($o) }}</option>
                            @endforeach
                        </select>
                        @error('option') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="location" class="form-label fw-semibold">Localisation <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $property->location) }}" required>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="area" class="form-label fw-semibold">Superficie (m²)</label>
                        <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area', $property->area) }}">
                        @error('area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="price" class="form-label fw-semibold">Prix (DT) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $property->price) }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $property->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="photos" class="form-label fw-semibold">Ajouter des photos</label>
                        <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*">
                        <div class="form-text">Les nouvelles photos s'ajouteront aux existantes.</div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-check-circle me-1"></i>Enregistrer
                    </button>
                    <a href="{{ route('bailleur.properties') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
