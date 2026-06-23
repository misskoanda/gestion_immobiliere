@extends('layouts.front')

@section('title', 'Propriétés Disponibles - ImmoManager')

@section('content')
    <!-- START PROPERTIES BANNER -->
    <section class="section-padding bg-dark text-white text-center py-5" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url({{ asset('front/img/bg/video.jpg') }}); background-size: cover; background-position: center;">
        <div class="container py-4">
            <h1 class="font-weight-extrabold text-white">Nos Propriétés Disponibles</h1>
            <p class="lead text-white-50">Découvrez l'ensemble de nos annonces immobilières actives en Tunisie.</p>
        </div>
    </section>

    <!-- START FILTER & LISTINGS -->
    <section class="section-padding bg-light py-5">
        <div class="container">
            <div class="row">
                
                <!-- Filters Sidebar -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm border">
                        <h4 class="font-weight-bold mb-4 font-18 text-dark"><i class="ti-filter text-primary"></i> Filtres</h4>
                        
                        <form action="{{ route('properties.index') }}" method="GET" class="space-y-4">
                            <!-- Type Filter -->
                            <div class="mb-3">
                                <label for="type" class="form-label text-muted text-xs font-weight-bold uppercase">Type de bien</label>
                                <select id="type" name="type" class="form-select border bg-light py-2" onchange="this.form.submit()">
                                    <option value="">Tous</option>
                                    <option value="villa" {{ request('type') === 'villa' ? 'selected' : '' }}>Villa</option>
                                    <option value="appartement" {{ request('type') === 'appartement' ? 'selected' : '' }}>Appartement</option>
                                    <option value="terrain" {{ request('type') === 'terrain' ? 'selected' : '' }}>Terrain</option>
                                    <option value="commerce" {{ request('type') === 'commerce' ? 'selected' : '' }}>Commerce</option>
                                    <option value="batiment" {{ request('type') === 'batiment' ? 'selected' : '' }}>Bâtiment</option>
                                </select>
                            </div>

                            <!-- Option Filter -->
                            <div class="mb-4">
                                <label for="option" class="form-label text-muted text-xs font-weight-bold uppercase">Option</label>
                                <select id="option" name="option" class="form-select border bg-light py-2" onchange="this.form.submit()">
                                    <option value="">Toutes</option>
                                    <option value="vente" {{ request('option') === 'vente' ? 'selected' : '' }}>Vente</option>
                                    <option value="location" {{ request('option') === 'location' ? 'selected' : '' }}>Location</option>
                                </select>
                            </div>

                            <!-- Reset Button -->
                            @if(request('type') || request('option'))
                                <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill font-weight-semibold">Réinitialiser</a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Listings Area -->
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        @forelse($properties as $property)
                            <div class="col-lg-6 col-md-12 col-sm-6 mb-4">
                                <div class="single_course bg-white rounded shadow-sm overflow-hidden h-100 d-flex flex-column border">
                                    <div class="single_c_img position-relative" style="height: 200px; overflow: hidden;">
                                        @if($property->mainPhoto)
                                            <img src="{{ asset('storage/' . $property->mainPhoto->path) }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="{{ $property->title }}" onerror="this.onerror=null;this.src='{{ asset('front/img/course/1.png') }}';">
                                        @else
                                            <img src="{{ asset('front/img/course/1.png') }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="default">
                                        @endif
                                        <span class="position-absolute top-0 right-0 m-3 px-3 py-1 bg-primary text-white text-xs font-weight-bold rounded-pill shadow-sm">
                                            {{ ucfirst($property->type) }}
                                        </span>
                                    </div>
                                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                                        <div>
                                            <span class="text-uppercase text-xs font-weight-bold tracking-wider {{ $property->option === 'vente' ? 'text-danger' : 'text-primary' }}">
                                                À la {{ $property->option }}
                                            </span>
                                            <h4 class="mt-2 font-weight-bold text-gray-950 font-18">
                                                <a href="{{ route('properties.show', $property) }}" class="text-dark hover-primary">{{ $property->title }}</a>
                                            </h4>
                                            <p class="text-muted text-xs my-2"><i class="ti-location-pin"></i> {{ $property->location }}</p>
                                            @if($property->area)
                                                <p class="text-muted text-xs mb-3"><i class="ti-layout-grid2"></i> Superficie : <b>{{ $property->area }} m²</b></p>
                                            @endif
                                        </div>
                                        <div class="border-top pt-3 d-flex justify-content-between align-items-center mt-3">
                                            <div class="price font-weight-extrabold text-primary font-18">{{ number_format($property->price, 2) }} FCFA</div>
                                            <a href="{{ route('properties.show', $property) }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">Détails</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Aucune propriété ne correspond à vos critères de recherche.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $properties->appends(request()->query())->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
