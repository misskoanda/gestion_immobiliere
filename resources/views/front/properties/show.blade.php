@extends('layouts.front')

@section('title', $property->title . ' - ImmoManager')

@section('content')
    <!-- BREADCRUMB -->
    <section class="section-padding bg-dark text-white py-4" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url({{ asset('front/img/bg/video.jpg') }}); background-size: cover;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.index') }}" class="text-white-50">Propriétés</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($property->title, 40) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- PROPERTY DETAIL -->
    <section class="section-padding bg-light py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8 mb-4">
                    <!-- Photo Gallery -->
                    <div class="bg-white rounded shadow-sm overflow-hidden mb-4">
                        @if($property->photos->count() > 0)
                            <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($property->photos as $index => $photo)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $photo->path) }}" class="d-block w-100" style="height: 450px; object-fit: cover;" alt="{{ $property->title }}" onerror="this.onerror=null;this.src='{{ asset('front/img/course/1.png') }}';">
                                        </div>
                                    @endforeach
                                </div>
                                @if($property->photos->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <img src="{{ asset('front/img/course/1.png') }}" class="d-block w-100" style="height: 450px; object-fit: cover;" alt="default">
                        @endif
                    </div>

                    <!-- Property Info -->
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                            <div>
                                <span class="badge {{ $property->option === 'vente' ? 'bg-danger' : 'bg-primary' }} mb-2 text-uppercase">À la {{ $property->option }}</span>
                                <h2 class="font-weight-bold mb-1">{{ $property->title }}</h2>
                                <p class="text-muted"><i class="ti-location-pin"></i> {{ $property->location }}</p>
                            </div>
                            <div class="text-end">
                                <h3 class="text-primary font-weight-extrabold mb-0">{{ number_format($property->price, 2) }} FCFA</h3>
                                <small class="text-muted">{{ $property->option === 'location' ? '/ mois' : '' }}</small>
                            </div>
                        </div>

                        <hr>

                        <!-- Characteristics -->
                        <div class="row mt-3">
                            <div class="col-sm-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="ti-home text-primary me-2 font-20"></span>
                                    <div><small class="text-muted d-block">Type</small><strong>{{ ucfirst($property->type) }}</strong></div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="ti-briefcase text-primary me-2 font-20"></span>
                                    <div><small class="text-muted d-block">Usage</small><strong>{{ ucfirst($property->usage) }}</strong></div>
                                </div>
                            </div>
                            @if($property->area)
                            <div class="col-sm-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="ti-layout-grid2 text-primary me-2 font-20"></span>
                                    <div><small class="text-muted d-block">Superficie</small><strong>{{ $property->area }} m²</strong></div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <hr>

                        <h5 class="font-weight-bold mb-3">Description</h5>
                        <p class="text-muted lh-lg">{{ $property->description }}</p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Actions Card -->
                    @auth
                        @if(auth()->user()->role === 'client')
                            <div class="bg-white rounded shadow-sm p-4 mb-4">
                                <h5 class="font-weight-bold mb-3"><i class="ti-heart text-danger"></i> Actions Client</h5>
                                <a href="#" class="btn btn-outline-danger w-100 mb-2 rounded-pill py-2" onclick="alert('Fonctionnalité favoris à intégrer');">
                                    <i class="ti-heart"></i> Ajouter aux favoris
                                </a>
                                <a href="#" class="btn btn-primary w-100 rounded-pill py-2" onclick="alert('Fonctionnalité demande de visite à intégrer');">
                                    <i class="ti-calendar"></i> Demander une visite
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="bg-white rounded shadow-sm p-4 mb-4">
                            <h5 class="font-weight-bold mb-3">Vous êtes intéressé ?</h5>
                            <p class="text-muted mb-3">Connectez-vous pour ajouter ce bien à vos favoris ou demander une visite.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 rounded-pill py-2 mb-2">Se connecter</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 rounded-pill py-2">Créer un compte</a>
                        </div>
                    @endauth

                    <!-- Property Summary Card -->
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="font-weight-bold mb-3"><i class="ti-info-alt text-primary"></i> Résumé</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Statut</span><span class="badge bg-success">{{ ucfirst($property->status) }}</span></li>
                            <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Type</span><strong>{{ ucfirst($property->type) }}</strong></li>
                            <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Usage</span><strong>{{ ucfirst($property->usage) }}</strong></li>
                            <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Option</span><strong>{{ ucfirst($property->option) }}</strong></li>
                            @if($property->area)
                            <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Superficie</span><strong>{{ $property->area }} m²</strong></li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Prix</span><strong class="text-primary">{{ number_format($property->price, 2) }} DT</strong></li>
                            @if($property->published_at)
                            <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Publié le</span><strong>{{ $property->published_at->format('d/m/Y') }}</strong></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
