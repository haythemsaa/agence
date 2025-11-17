<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Agence de Voyage Tunisie') }} - Agence de Voyage Tunisie</title>
        <meta name="description" content="Réservez vos hôtels, circuits et voyages organisés en Tunisie et à l'international. Omra, séjours balnéaires, circuits découverte.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <!-- Navigation -->
            <nav x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="flex items-center">
                                    <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="ml-3 text-xl font-bold text-gray-900">Agence Voyage</span>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-blue-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                    Accueil
                                </a>
                                <a href="{{ route('hotels.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('hotels.*') ? 'border-blue-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                    Hôtels
                                </a>
                                <a href="{{ route('packages.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('packages.*') ? 'border-blue-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                    Voyages Organisés
                                </a>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6 sm:space-x-3">
                            <!-- Language Switcher -->
                            <x-language-switcher />

                            <!-- Currency Switcher -->
                            <x-currency-switcher />

                            @auth
                                <div class="flex items-center space-x-4">
                                    <!-- Loyalty Badge -->
                                    <div class="flex items-center px-3 py-1 rounded-full text-xs font-semibold {{
                                        auth()->user()->loyalty_level === 'platinum' ? 'bg-purple-100 text-purple-800' :
                                        (auth()->user()->loyalty_level === 'gold' ? 'bg-yellow-100 text-yellow-800' :
                                        (auth()->user()->loyalty_level === 'silver' ? 'bg-gray-100 text-gray-800' : 'bg-orange-100 text-orange-800'))
                                    }}">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        {{ ucfirst(auth()->user()->loyalty_level) }} - {{ auth()->user()->loyalty_points }} pts
                                    </div>

                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <div>{{ Auth::user()->name }}</div>
                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            @if(auth()->user()->isAdmin())
                                                <x-dropdown-link :href="route('admin.dashboard')">
                                                    Administration
                                                </x-dropdown-link>
                                            @endif
                                            <x-dropdown-link :href="route('dashboard')">
                                                Mes Réservations
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('wishlist.index')">
                                                Mes Favoris
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('referrals.index')">
                                                Parrainage
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('profile.edit')">
                                                Mon Profil
                                            </x-dropdown-link>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                                    Déconnexion
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @else
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
                                        Connexion
                                    </a>
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Inscription
                                    </a>
                                </div>
                            @endauth
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                            Accueil
                        </a>
                        <a href="{{ route('hotels.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('hotels.*') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                            Hôtels
                        </a>
                        <a href="{{ route('packages.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('packages.*') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                            Voyages Organisés
                        </a>
                    </div>

                    <!-- Currency Switcher Mobile -->
                    <div class="px-4 py-3 border-t border-gray-200">
                        <x-currency-switcher />
                    </div>

                    @auth
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="px-4">
                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                        Administration
                                    </a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                    Mes Réservations
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                    Mes Favoris
                                </a>
                                <a href="{{ route('referrals.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                    Parrainage
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                    Mon Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                        Déconnexion
                                    </a>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                    Connexion
                                </a>
                                <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                    Inscription
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </nav>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white mt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Agence de Voyage</h3>
                            <p class="text-gray-400 text-sm">
                                Votre partenaire de confiance pour tous vos voyages en Tunisie et à l'international.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Nos Services</h3>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li><a href="{{ route('hotels.index') }}" class="hover:text-white">Réservation d'hôtels</a></li>
                                <li><a href="{{ route('packages.index') }}" class="hover:text-white">Voyages organisés</a></li>
                                <li><a href="{{ route('packages.index') }}?type=omra" class="hover:text-white">Omra</a></li>
                                <li><a href="{{ route('packages.index') }}?type=circuit" class="hover:text-white">Circuits</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informations</h3>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li><a href="#" class="hover:text-white">À propos</a></li>
                                <li><a href="#" class="hover:text-white">Conditions générales</a></li>
                                <li><a href="#" class="hover:text-white">Politique de confidentialité</a></li>
                                <li><a href="#" class="hover:text-white">Contact</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Contact</h3>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li>📞 +216 XX XXX XXX</li>
                                <li>📧 contact@agence-voyage.tn</li>
                                <li>📍 Tunis, Tunisie</li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                        <p>&copy; {{ date('Y') }} Agence de Voyage Tunisie. Tous droits réservés. Développé pour CHOKRI.</p>
                    </div>
                </div>
            </footer>
        </div>

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

            // Set user info if authenticated
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
