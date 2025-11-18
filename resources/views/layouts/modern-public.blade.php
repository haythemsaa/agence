<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Agence de Voyage Tunisie') }} - Agence de Voyage Tunisie</title>
    <meta name="description" content="Réservez vos hôtels, circuits et voyages organisés en Tunisie et à l'international. Omra, séjours balnéaires, circuits découverte.">

    <!-- Google Fonts - Elegant Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #1a5490;
            --secondary-color: #f39c12;
            --accent-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-luxury: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            --shadow-sm: 0 2px 10px rgba(0,0,0,0.08);
            --shadow-md: 0 5px 25px rgba(0,0,0,0.12);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            line-height: 1.7;
            color: var(--dark-color);
            overflow-x: hidden;
            background: #fff;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            line-height: 1.3;
        }

        /* Modern Navbar */
        .navbar-modern {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1rem 0;
        }

        .navbar-modern.scrolled {
            padding: 0.5rem 0;
            box-shadow: var(--shadow-md);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark-color) !important;
            margin: 0 0.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--gradient-primary);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Elegant Buttons */
        .btn-elegant-primary {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-elegant-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-elegant-primary:hover::before {
            left: 100%;
        }

        .btn-elegant-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-elegant-secondary {
            background: var(--gradient-secondary);
            border: none;
            color: white;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
        }

        .btn-elegant-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(240, 147, 251, 0.5);
        }

        /* Elegant Cards */
        .card-elegant {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
            background: white;
        }

        .card-elegant:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-lg);
        }

        .card-elegant .card-img-top {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            height: 250px;
            object-fit: cover;
        }

        .card-elegant:hover .card-img-top {
            transform: scale(1.1);
        }

        .card-elegant .card-body {
            padding: 1.5rem;
        }

        /* Badge Styles */
        .badge-luxury {
            background: var(--gradient-luxury);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Back to Top Button */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            border: none;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 999;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        #backToTop.show {
            opacity: 1;
            visibility: visible;
        }

        #backToTop:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        /* Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Footer Modern */
        .footer-modern {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 4rem 0 2rem;
            position: relative;
            overflow: hidden;
        }

        .footer-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        }

        .footer-modern h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-modern a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-modern a:hover {
            color: white;
            transform: translateX(5px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.4rem;
            }

            .btn-elegant-primary,
            .btn-elegant-secondary {
                padding: 10px 25px;
                font-size: 0.9rem;
            }
        }

        /* Section Spacing */
        .section-padding {
            padding: 80px 0;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Modern Navbar -->
    <nav class="navbar navbar-expand-lg navbar-modern fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-airplane-fill me-2"></i>
                VoyageLuxe
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('hotels.*') ? 'active' : '' }}" href="{{ route('hotels.index') }}">
                            <i class="bi bi-building me-1"></i> Hôtels
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('packages.*') ? 'active' : '' }}" href="{{ route('packages.index') }}">
                            <i class="bi bi-map me-1"></i> Voyages
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-grid me-1"></i> Services
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('packages.index') }}?type=omra"><i class="bi bi-star me-2"></i>Omra</a></li>
                            <li><a class="dropdown-item" href="{{ route('visa-services') }}"><i class="bi bi-passport me-2"></i>Services Visa</a></li>
                            <li><a class="dropdown-item" href="{{ route('gift-vouchers.index') }}"><i class="bi bi-gift me-2"></i>Chèques Cadeaux</a></li>
                            <li><a class="dropdown-item" href="{{ route('agencies') }}"><i class="bi bi-geo-alt me-2"></i>Nos Agences</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.index') }}">
                            <i class="bi bi-journal-text me-1"></i> Blog
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <!-- Language & Currency -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-globe"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><x-language-switcher /></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><x-currency-switcher /></li>
                        </ul>
                    </div>

                    @auth
                        <!-- Loyalty Badge -->
                        <span class="badge badge-luxury">
                            <i class="bi bi-star-fill"></i>
                            {{ ucfirst(auth()->user()->loyalty_level) }}
                        </span>

                        <!-- User Menu -->
                        <div class="dropdown">
                            <button class="btn btn-elegant-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ Str::limit(Auth::user()->name, 10) }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Administration</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-calendar-check me-2"></i>Mes Réservations</a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist.index') }}"><i class="bi bi-heart me-2"></i>Mes Favoris</a></li>
                                <li><a class="dropdown-item" href="{{ route('referrals.index') }}"><i class="bi bi-share me-2"></i>Parrainage</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Mon Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-elegant-primary">
                            <i class="bi bi-person-plus me-1"></i> Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 80px;">
            <div class="toast show" role="alert">
                <div class="toast-header bg-success text-white">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong class="me-auto">Succès</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 80px;">
            <div class="toast show" role="alert">
                <div class="toast-header bg-danger text-white">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong class="me-auto">Erreur</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        {{ $slot }}
    </main>

    <!-- Modern Footer -->
    <footer class="footer-modern">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5><i class="bi bi-airplane-fill me-2"></i>VoyageLuxe</h5>
                    <p class="text-white-50">
                        Votre partenaire de confiance pour tous vos voyages en Tunisie et à l'international.
                        Plus de 15 ans d'expérience et 50,000+ voyageurs satisfaits.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5>Nos Services</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('hotels.index') }}"><i class="bi bi-chevron-right me-1"></i>Hôtels</a></li>
                        <li class="mb-2"><a href="{{ route('packages.index') }}"><i class="bi bi-chevron-right me-1"></i>Voyages Organisés</a></li>
                        <li class="mb-2"><a href="{{ route('packages.index') }}?type=omra"><i class="bi bi-chevron-right me-1"></i>Omra</a></li>
                        <li class="mb-2"><a href="{{ route('visa-services') }}"><i class="bi bi-chevron-right me-1"></i>Services Visa</a></li>
                        <li class="mb-2"><a href="{{ route('gift-vouchers.index') }}"><i class="bi bi-chevron-right me-1"></i>Chèques Cadeaux</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Informations</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('agencies') }}"><i class="bi bi-chevron-right me-1"></i>Nos Agences</a></li>
                        <li class="mb-2"><a href="{{ route('blog.index') }}"><i class="bi bi-chevron-right me-1"></i>Blog Voyage</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>À propos</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Conditions générales</a></li>
                        <li class="mb-2"><a href="#"><i class="bi bi-chevron-right me-1"></i>Confidentialité</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-telephone-fill me-2"></i>
                            +216 XX XXX XXX
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope-fill me-2"></i>
                            contact@voyageluxe.tn
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            Tunis, Tunisie
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 bg-white opacity-25">

            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-white-50">
                        &copy; {{ date('Y') }} VoyageLuxe. Tous droits réservés.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-white-50">
                        Développé avec <i class="bi bi-heart-fill text-danger"></i> pour CHOKRI
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" title="Retour en haut">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- WhatsApp Floating Button -->
    <x-whatsapp-button />

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Modern Animations -->
    <script src="{{ asset('js/modern-animations.js') }}"></script>

    <!-- Custom JavaScript -->
    <script>
        // Initialize AOS Animations
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Page Loader
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('pageLoader').classList.add('hidden');
            }, 500);
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            const backToTop = document.getElementById('backToTop');

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Back to Top Button
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        // Back to Top Functionality
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth Scroll for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-hide Toast Messages
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });

        // Add hover effect to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-elegant');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-15px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // Parallax Effect for Hero Section
        window.addEventListener('scroll', function() {
            const parallaxElements = document.querySelectorAll('[data-parallax]');
            parallaxElements.forEach(element => {
                const speed = element.dataset.parallax || 0.5;
                const yPos = -(window.scrollY * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
    </script>

    <!-- Tawk.to Live Chat Widget -->
    @if(config('services.tawkto.property_id') && config('services.tawkto.widget_id'))
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/{{ config("services.tawkto.property_id") }}/{{ config("services.tawkto.widget_id") }}';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();

        @auth
        Tawk_API.onLoad = function(){
            Tawk_API.setAttributes({
                'name': '{{ auth()->user()->name }}',
                'email': '{{ auth()->user()->email }}',
                'hash': '{{ hash_hmac("sha256", auth()->user()->email, config("services.tawkto.api_key", "")) }}'
            }, function(error){});
        };
        @endauth
    </script>
    @endif
</body>
</html>
