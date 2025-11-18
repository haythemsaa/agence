@props(['variant' => 'default'])

@php
$variantStyles = [
    'default' => 'bg-white',
    'glass' => 'bg-white bg-opacity-90 backdrop-blur',
    'dark' => 'bg-dark text-white'
];
$bgClass = $variantStyles[$variant] ?? $variantStyles['default'];
@endphp

<div class="card border-0 shadow-lg {{ $bgClass }}" style="border-radius: 20px;" data-aos="fade-up" data-aos-delay="200">
    <div class="card-body p-4">
        <ul class="nav nav-pills mb-4 justify-content-center" id="searchTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-4 py-2 rounded-pill" id="hotels-tab" data-bs-toggle="pill" data-bs-target="#hotels" type="button">
                    <i class="bi bi-building me-2"></i>Hôtels
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 rounded-pill" id="packages-tab" data-bs-toggle="pill" data-bs-target="#packages" type="button">
                    <i class="bi bi-map me-2"></i>Voyages
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 rounded-pill" id="omra-tab" data-bs-toggle="pill" data-bs-target="#omra" type="button">
                    <i class="bi bi-star me-2"></i>Omra
                </button>
            </li>
        </ul>

        <div class="tab-content" id="searchTabContent">
            <!-- Hotels Search -->
            <div class="tab-pane fade show active" id="hotels" role="tabpanel">
                <form action="{{ route('hotels.search') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>Destination
                            </label>
                            <select name="destination" class="form-select form-select-lg" required>
                                <option value="">Choisir une destination</option>
                                @foreach($destinations ?? [] as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar me-1"></i>Arrivée
                            </label>
                            <input type="date" name="check_in" class="form-control form-control-lg" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-check me-1"></i>Départ
                            </label>
                            <input type="date" name="check_out" class="form-control form-control-lg" required min="{{ date('Y-m-d', strtotime('+2 days')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-people me-1"></i>Adultes
                            </label>
                            <input type="number" name="adults" class="form-control form-control-lg" min="1" max="9" value="2" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Enfants
                            </label>
                            <input type="number" name="children" class="form-control form-control-lg" min="0" max="9" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-door-open me-1"></i>Chambres
                            </label>
                            <input type="number" name="rooms" class="form-control form-control-lg" min="1" max="9" value="1">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-elegant-primary btn-lg w-100">
                                <i class="bi bi-search me-2"></i>Rechercher des Hôtels
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Packages Search -->
            <div class="tab-pane fade" id="packages" role="tabpanel">
                <form action="{{ route('packages.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-tag me-1"></i>Type de voyage
                            </label>
                            <select name="type" class="form-select form-select-lg">
                                <option value="">Tous les types</option>
                                <option value="circuit">Circuits</option>
                                <option value="sejour">Séjours</option>
                                <option value="omra">Omra</option>
                                <option value="international">International</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>Destination
                            </label>
                            <input type="text" name="destination" class="form-control form-control-lg" placeholder="Ex: Djerba, Istanbul...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-currency-dollar me-1"></i>Budget maximum
                            </label>
                            <input type="number" name="max_price" class="form-control form-control-lg" placeholder="Ex: 2000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-range me-1"></i>Durée (jours)
                            </label>
                            <input type="number" name="duration" class="form-control form-control-lg" placeholder="Ex: 7">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-elegant-secondary btn-lg w-100">
                                <i class="bi bi-search me-2"></i>Rechercher des Voyages
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Omra Search -->
            <div class="tab-pane fade" id="omra" role="tabpanel">
                <form action="{{ route('packages.index') }}" method="GET">
                    <input type="hidden" name="type" value="omra">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar me-1"></i>Mois de départ
                            </label>
                            <select name="month" class="form-select form-select-lg">
                                <option value="">Tous les mois</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-people me-1"></i>Nombre de personnes
                            </label>
                            <input type="number" name="people" class="form-control form-control-lg" min="1" value="1">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i>Catégorie d'hôtel
                            </label>
                            <select name="hotel_category" class="form-select form-select-lg">
                                <option value="">Toutes catégories</option>
                                <option value="5">5 étoiles</option>
                                <option value="4">4 étoiles</option>
                                <option value="3">3 étoiles</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-elegant-primary btn-lg w-100">
                                <i class="bi bi-search me-2"></i>Rechercher une Omra
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        background: transparent;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }
</style>
