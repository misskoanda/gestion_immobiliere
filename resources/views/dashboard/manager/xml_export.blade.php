@extends('layouts.dashboard')

@section('title', 'Export XML')

@section('content')
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-filetype-xml text-danger me-2"></i>Export XML des Propriétés</h4>
    </div>

    <!-- Export Button -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h6 class="fw-bold mb-1">Générer un nouvel export XML</h6>
                <p class="text-muted small mb-0">Exporte toutes les propriétés publiées au format XML.</p>
            </div>
            <form action="{{ route('manager.xml_export.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger rounded-pill px-4">
                    <i class="bi bi-download me-1"></i>Exporter
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- Export History -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Historique des Exports</h6>
        </div>
        <div class="card-body p-0">
            @if(Auth::user()->xmlExports->isEmpty())
                <p class="text-muted p-4 mb-0">Aucun export XML généré.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-uppercase text-muted fw-semibold">Fichier</th>
                                <th class="small text-uppercase text-muted fw-semibold">Date d'export</th>
                                <th class="small text-uppercase text-muted fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->xmlExports()->latest()->get() as $export)
                                <tr>
                                    <td class="fw-semibold small">
                                        <i class="bi bi-file-earmark-code text-danger me-1"></i>{{ basename($export->file_path) }}
                                    </td>
                                    <td class="small text-muted">{{ $export->exported_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $export->file_path) }}" class="btn btn-sm btn-outline-primary" download>
                                            <i class="bi bi-download me-1"></i>Télécharger
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
