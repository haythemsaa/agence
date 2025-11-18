<x-modern-public-layout>
    <x-slot name="title">Accueil</x-slot>

    <!-- Hero Carousel Slider -->
    <section id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slide 1 - Découverte -->
            <div class="carousel-item active">
                <div class="position-relative" style="height: 85vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); overflow: hidden;">
                    <div class="position-absolute w-100 h-100" style="background: url('https://images.unsplash.com/photo-1682687220742-aba13b6e50ba?w=1920') center/cover; opacity: 0.3;" data-parallax="0.3"></div>
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-lg-8 text-white" data-aos="fade-right">
                                <span class="badge badge-luxury mb-3" style="font-size: 1rem;">
                                    <i class="bi bi-star-fill me-2"></i>Voyages de Luxe
                                </span>
                                <h1 class="display-1 fw-bold mb-4" style="font-size: 4rem; line-height: 1.2;">
                                    Découvrez la Tunisie <br>
                                    <span style="background: linear-gradient(to right, #ffd89b, #19547b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                        Autrement
                                    </span>
                                </h1>
                                <p class="lead mb-4" style="font-size: 1.3rem; opacity: 0.95;">
                                    Hôtels 5 étoiles, circuits personnalisés et expériences uniques
                                </p>
                                <div class="d-flex gap-3 flex-wrap">
                                    <a href="{{ route('hotels.index') }}" class="btn btn-elegant-primary btn-lg">
                                        <i class="bi bi-search me-2"></i>Explorer nos Hôtels
                                    </a>
                                    <a href="{{ route('packages.index') }}" class="btn btn-elegant-secondary btn-lg">
                                        <i class="bi bi-map me-2"></i>Voir les Voyages
                                    </a>
                                </div>
                                <div class="mt-4 d-flex align-items-center gap-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-warning me-2" style="font-size: 1.5rem;"></i>
                                        <span style="font-size: 1.1rem;">50,000+ Voyageurs</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-award-fill text-warning me-2" style="font-size: 1.5rem;"></i>
                                        <span style="font-size: 1.1rem;">15+ Ans d'Expérience</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 - Omra -->
            <div class="carousel-item">
                <div class="position-relative" style="height: 85vh; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); overflow: hidden;">
                    <div class="position-absolute w-100 h-100" style="background: url('https://images.unsplash.com/photo-1564769662533-4f00a87b4056?w=1920') center/cover; opacity: 0.25;"></div>
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-lg-8 text-white" data-aos="fade-left">
                                <span class="badge bg-success mb-3" style="font-size: 1rem; padding: 10px 20px;">
                                    <i class="bi bi-star-fill me-2"></i>Forfaits Omra Premium
                                </span>
                                <h1 class="display-1 fw-bold mb-4">
                                    Accomplissez Votre <br>
                                    <span style="color: #ffd700;">Omra en Toute Sérénité</span>
                                </h1>
                                <p class="lead mb-4" style="font-size: 1.3rem;">
                                    Accompagnement personnalisé, hébergement 5*, vols directs
                                </p>
                                <a href="{{ route('packages.index') }}?type=omra" class="btn btn-light btn-lg px-5">
                                    <i class="bi bi-calendar-check me-2"></i>Réserver maintenant
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 - International -->
            <div class="carousel-item">
                <div class="position-relative" style="height: 85vh; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); overflow: hidden;">
                    <div class="position-absolute w-100 h-100" style="background: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920') center/cover; opacity: 0.3;"></div>
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-lg-8 text-white" data-aos="fade-up">
                                <span class="badge badge-luxury mb-3" style="font-size: 1rem;">
                                    <i class="bi bi-globe me-2"></i>Destinations Internationales
                                </span>
                                <h1 class="display-1 fw-bold mb-4">
                                    Explorez le Monde <br>
                                    <span style="color: #ffd700;">Avec Nous</span>
                                </h1>
                                <p class="lead mb-4" style="font-size: 1.3rem;">
                                    Plus de 120 destinations, circuits sur-mesure, prix imbattables
                                </p>
                                <a href="{{ route('packages.index') }}?type=international" class="btn btn-elegant-primary btn-lg">
                                    <i class="bi bi-airplane-fill me-2"></i>Découvrir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </section>

    <!-- Trust Badges Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-shield-fill-check text-primary" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2 mb-0">{{ config('app.years_experience', 15) }}+ Ans</h5>
                        <small class="text-muted">D'expérience</small>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-people-fill text-success" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2 mb-0">{{ number_format(config('app.total_clients', 50000)) }}+</h5>
                        <small class="text-muted">Clients satisfaits</small>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-star-fill text-warning" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2 mb-0">{{ config('app.google_rating', 4.8) }}/5</h5>
                        <small class="text-muted">Note Google</small>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="400">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-lock-fill text-info" style="font-size: 2.5rem;"></i>
                        <h5 class="mt-2 mb-0">100%</h5>
                        <small class="text-muted">Paiement sécurisé</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Hotels Section -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge bg-primary mb-2">NOS MEILLEURS HÔTELS</span>
                <h2 class="display-4 fw-bold mb-3">Hôtels Populaires</h2>
                <p class="lead text-muted">Découvrez nos sélections d'hôtels de luxe en Tunisie</p>
            </div>

            <div class="row g-4">
                @foreach($featuredHotels as $index => $hotel)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="card card-elegant h-100">
                            <div class="position-relative overflow-hidden">
                                @if(!empty($hotel->images) && count($hotel->images) > 0)
                                    <img src="{{ $hotel->images[0] }}" class="card-img-top" alt="{{ $hotel->name }}">
                                @else
                                    <div class="card-img-top bg-gradient" style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                @endif
                                @if($hotel->is_featured)
                                    <span class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star-fill"></i> Vedette
                                        </span>
                                    </span>
                                @endif
                                @if($hotel->is_flash_sale ?? false)
                                    <span class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-danger">
                                            <i class="bi bi-lightning-fill"></i> Promo Flash
                                        </span>
                                    </span>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ Str::limit($hotel->name, 25) }}</h5>
                                    <div class="text-warning">
                                        @for($i = 0; $i < $hotel->stars; $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt-fill me-1"></i>{{ $hotel->city }}, {{ $hotel->country }}
                                </p>
                                @if($hotel->rating > 0)
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="badge bg-primary me-2">{{ number_format($hotel->rating, 1) }}</span>
                                        <small class="text-muted">({{ $hotel->reviews_count }} avis)</small>
                                    </div>
                                @endif
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-elegant-primary w-100">
                                    <i class="bi bi-eye me-2"></i>Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('hotels.index') }}" class="btn btn-outline-primary btn-lg">
                    Voir tous les hôtels <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Packages Section -->
    <section class="section-padding" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge badge-luxury mb-2">VOYAGES ORGANISÉS</span>
                <h2 class="display-4 fw-bold mb-3">Nos Meilleurs Circuits</h2>
                <p class="lead text-muted">Circuits, Omra et séjours tout compris</p>
            </div>

            <div class="row g-4">
                @foreach($featuredPackages as $index => $package)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="card card-elegant h-100">
                            <div class="position-relative overflow-hidden">
                                <div class="card-img-top" style="height: 280px; background: {{
                                    $package->type === 'omra' ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' :
                                    ($package->type === 'circuit' ? 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)' :
                                    ($package->type === 'sejour' ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'))
                                }}; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-geo-alt-fill text-white" style="font-size: 5rem; opacity: 0.3;"></i>
                                </div>
                                <span class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-white text-dark text-uppercase fw-bold">
                                        {{ $package->type }}
                                    </span>
                                </span>
                                @if($package->is_tre_package ?? false)
                                    <span class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-success">
                                            <i class="bi bi-globe"></i> TRE
                                        </span>
                                    </span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-3">{{ $package->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($package->short_description, 100) }}</p>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-calendar3 text-primary me-2"></i>
                                        <small>{{ $package->duration_days }} jours / {{ $package->duration_nights }} nuits</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-geo-alt text-primary me-2"></i>
                                        <small>{{ implode(', ', array_slice($package->destinations, 0, 2)) }}</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block">À partir de</small>
                                        <h4 class="mb-0 text-primary">{{ number_format($package->price_adult, 0) }} <small>{{ $package->currency }}</small></h4>
                                    </div>
                                    <a href="{{ route('packages.show', $package->slug) }}" class="btn btn-elegant-primary">
                                        Détails <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('packages.index') }}" class="btn btn-elegant-secondary btn-lg">
                    Voir tous les voyages <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-3">Pourquoi Nous Choisir ?</h2>
                <p class="lead text-muted">Des services premium pour une expérience inoubliable</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-delay="100">
                    <div class="text-center p-4 h-100">
                        <div class="mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4">
                                <i class="bi bi-award-fill text-primary" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Meilleurs Prix</h4>
                        <p class="text-muted">Prix compétitifs et transparents garantis</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-delay="200">
                    <div class="text-center p-4 h-100">
                        <div class="mb-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4">
                                <i class="bi bi-stars text-success" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Programme Fidélité</h4>
                        <p class="text-muted">Cumulez des points à chaque réservation</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-delay="300">
                    <div class="text-center p-4 h-100">
                        <div class="mb-4">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-4">
                                <i class="bi bi-headset text-info" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Support 24/7</h4>
                        <p class="text-muted">Service client disponible à tout moment</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-delay="400">
                    <div class="text-center p-4 h-100">
                        <div class="mb-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4">
                                <i class="bi bi-shield-check text-warning" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Paiement Sécurisé</h4>
                        <p class="text-muted">Plusieurs modes de paiement sûrs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @if($recentReviews->isNotEmpty())
    <section class="section-padding" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="text-center mb-5 text-white" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-3">Ce Que Disent Nos Clients</h2>
                <p class="lead">Découvrez les expériences de nos voyageurs</p>
            </div>

            <div class="row g-4">
                @foreach($recentReviews->take(3) as $index => $review)
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="card border-0 h-100 shadow-lg">
                            <div class="card-body p-4">
                                <div class="text-warning mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                                <p class="mb-4">"{{ Str::limit($review->comment, 120) }}"</p>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 50px; height: 50px;">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ $review->user->name }}</h6>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <section class="section-padding bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-5 fw-bold mb-3">Restez Informé de Nos Offres</h2>
                    <p class="lead mb-0">Inscrivez-vous à notre newsletter et recevez nos meilleures offres exclusives</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control form-control-lg" placeholder="Votre adresse email" required>
                        <button type="submit" class="btn btn-elegant-primary btn-lg px-4 text-nowrap">
                            <i class="bi bi-envelope-fill me-2"></i>S'inscrire
                        </button>
                    </form>
                    <small class="text-white-50 d-block mt-2">
                        <i class="bi bi-lock-fill me-1"></i>Vos données sont sécurisées et ne seront jamais partagées
                    </small>
                </div>
            </div>
        </div>
    </section>
</x-modern-public-layout>
