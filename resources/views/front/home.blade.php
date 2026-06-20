@extends('layouts.front')

@section('title', 'Accueil - Gestion Immobilière Premium')

@section('content')
    <!-- START HOME -->
    <section class="home_bg hb_height" style="background-image: url({{ asset('front/img/bg/home-bg.jpg') }}); background-size: cover; background-position: center center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-sm-12 col-xs-12">
                    <div class="hero-text ht_top">
                        <h1><span>ImmoGestion</span> Trouvez le bien immobilier idéal</h1>
                        <p class="lead text-white bg-dark bg-opacity-25 p-2 rounded">
                            Découvrez notre sélection de villas, appartements, terrains et locaux commerciaux en Tunisie.
                        </p>
                    </div>
                    <div class="home_sb bg-white p-4 rounded shadow-lg mt-4">
                        <form action="{{ route('properties.index') }}" method="GET" class="row g-2">
                            <div class="col-md-5">
                                <select name="type" class="form-select border-0 bg-light py-3">
                                    <option value="">Tous types de biens</option>
                                    <option value="villa">Villas</option>
                                    <option value="appartement">Appartements</option>
                                    <option value="terrain">Terrains</option>
                                    <option value="commerce">Commerces</option>
                                    <option value="batiment">Bâtiments</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="option" class="form-select border-0 bg-light py-3">
                                    <option value="">Option</option>
                                    <option value="vente">À Vendre</option>
                                    <option value="location">À Louer</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 py-3 font-weight-bold">Chercher</button>
                            </div>
                        </form>
                    </div>
                </div><!--- END COL -->
                <div class="col-lg-5 col-sm-12 col-xs-12 align-self-center">
                    <div class="hero-text-img text-center">
                        <img src="{{ asset('front/img/about3.png') }}" class="img-fluid rounded-circle shadow" alt="Biens" style="max-height: 400px; object-fit: cover; border: 8px solid rgba(255,255,255,0.2);" />
                    </div>
                </div><!--- END COL -->
            </div><!--- END ROW -->
        </div><!--- END CONTAINER -->
    </section>
    <!-- END HOME -->

    <!-- START COUNTER SECTION -->
    <section class="count_area counter_feature py-5 bg-white border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="single-counter text-center p-3">
                        <span class="ti-home text-primary font-30 mb-2 d-block"></span>
                        <h2 class="counter-num font-weight-bold">{{ \App\Models\Property::where('status', 'publiee')->count() }}</h2>
                        <p class="text-muted">Propriétés Publiées</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="single-counter text-center p-3">
                        <span class="ti-user text-primary font-30 mb-2 d-block"></span>
                        <h2 class="counter-num font-weight-bold">{{ \App\Models\User::where('role', 'client')->count() }}</h2>
                        <p class="text-muted">Clients Inscrits</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="single-counter text-center p-3">
                        <span class="ti-id-badge text-primary font-30 mb-2 d-block"></span>
                        <h2 class="counter-num font-weight-bold">{{ \App\Models\User::where('role', 'agent')->count() }}</h2>
                        <p class="text-muted">Agents Dédiés</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="single-counter text-center p-3">
                        <span class="ti-check-box text-primary font-30 mb-2 d-block"></span>
                        <h2 class="counter-num font-weight-bold">{{ \App\Models\Property::count() }}</h2>
                        <p class="text-muted">Biens Totaux référencés</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- START RECENT PROPERTIES -->
    <section class="home_course section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-6 col-xs-12">
                    <div class="section-title">
                        <h2>Découvrez nos <b>derniers biens</b> mis en ligne</h2>
                        <p class="text-muted">Consultez les dernières annonces vérifiées par nos agents immobiliers.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12 align-self-end text-end pb-4">
                    <a href="{{ route('properties.index') }}" class="btn_one">Toutes les Propriétés <i class="ti-arrow-top-right"></i></a>
                </div>
            </div>

            <div class="row mt-4">
                @forelse($properties as $property)
                    <div class="col-lg-4 col-sm-6 col-xs-12 mb-4">
                        <div class="single_course bg-white rounded shadow-sm overflow-hidden h-100 d-flex flex-column">
                            <div class="single_c_img position-relative" style="height: 220px; overflow: hidden;">
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
                                    <div class="price font-weight-extrabold text-primary font-20">{{ number_format($property->price, 2) }} DT</div>
                                    <a href="{{ route('properties.show', $property) }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">Détails</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Aucune propriété disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
