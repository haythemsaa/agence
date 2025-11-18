<x-public-layout>
    <x-slot name="title">Accueil</x-slot>

    <!-- Hero Section with Search -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Découvrez la Tunisie et le Monde
                </h1>
                <p class="text-xl text-blue-100">
                    Hôtels, circuits, Omra et voyages organisés - Réservez en toute confiance
                </p>
            </div>

            <!-- Search Tabs -->
            <div class="max-w-4xl mx-auto">
                <div x-data="{ tab: 'hotels' }" class="bg-white rounded-lg shadow-xl p-6">
                    <!-- Tab Headers -->
                    <div class="flex border-b border-gray-200 mb-6">
                        <button @click="tab = 'hotels'" :class="tab === 'hotels' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-2 px-4 border-b-2 font-medium text-sm focus:outline-none transition duration-150 ease-in-out">
                            Hôtels
                        </button>
                        <button @click="tab = 'packages'" :class="tab === 'packages' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-2 px-4 border-b-2 font-medium text-sm focus:outline-none transition duration-150 ease-in-out">
                            Voyages Organisés
                        </button>
                    </div>

                    <!-- Hotel Search Form -->
                    <div x-show="tab === 'hotels'" x-cloak>
                        <form action="{{ route('hotels.search') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                                    <select name="destination" id="destination" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Choisir une destination</option>
                                        @foreach($destinations as $code => $name)
                                            <option value="{{ $code }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="check_in" class="block text-sm font-medium text-gray-700 mb-1">Arrivée</label>
                                        <input type="date" name="check_in" id="check_in" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="check_out" class="block text-sm font-medium text-gray-700 mb-1">Départ</label>
                                        <input type="date" name="check_out" id="check_out" required min="{{ date('Y-m-d', strtotime('+2 days')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="adults" class="block text-sm font-medium text-gray-700 mb-1">Adultes</label>
                                    <input type="number" name="adults" id="adults" min="1" max="9" value="2" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="children" class="block text-sm font-medium text-gray-700 mb-1">Enfants</label>
                                    <input type="number" name="children" id="children" min="0" max="9" value="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="rooms" class="block text-sm font-medium text-gray-700 mb-1">Chambres</label>
                                    <input type="number" name="rooms" id="rooms" min="1" max="9" value="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                Rechercher des hôtels
                            </button>
                        </form>
                    </div>

                    <!-- Package Search Form -->
                    <div x-show="tab === 'packages'" x-cloak>
                        <form action="{{ route('packages.index') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="package_type" class="block text-sm font-medium text-gray-700 mb-1">Type de voyage</label>
                                    <select name="type" id="package_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Tous les types</option>
                                        <option value="circuit">Circuits</option>
                                        <option value="sejour">Séjours</option>
                                        <option value="omra">Omra</option>
                                        <option value="international">International</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="destination_package" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                                    <input type="text" name="destination" id="destination_package" placeholder="Ex: Djerba, Istanbul..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                Rechercher des voyages
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trust Badges -->
    <x-trust-badges />

    <!-- Featured Hotels Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Hôtels Populaires</h2>
                <p class="text-gray-600 mt-2">Découvrez nos meilleurs hôtels en Tunisie</p>
            </div>
            <a href="{{ route('hotels.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                Voir tous les hôtels →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredHotels as $hotel)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="relative h-48">
                        @if(!empty($hotel->images) && count($hotel->images) > 0)
                            <img src="{{ $hotel->images[0] }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                        @endif
                        @if($hotel->is_featured)
                            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                Vedette
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $hotel->name }}</h3>
                            <div class="flex items-center text-yellow-400">
                                @for($i = 0; $i < $hotel->stars; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">
                            📍 {{ $hotel->city }}, {{ $hotel->country }}
                        </p>
                        @if($hotel->rating > 0)
                            <div class="flex items-center mb-3">
                                <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm font-semibold">{{ number_format($hotel->rating, 1) }}</span>
                                <span class="ml-2 text-sm text-gray-600">({{ $hotel->reviews_count }} avis)</span>
                            </div>
                        @endif
                        <a href="{{ route('hotels.show', $hotel->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-150 ease-in-out">
                            Voir les détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Packages Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Voyages Organisés</h2>
                    <p class="text-gray-600 mt-2">Circuits, Omra et séjours tout compris</p>
                </div>
                <a href="{{ route('packages.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    Voir tous les voyages →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredPackages as $package)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="relative h-56">
                            <div class="w-full h-full bg-gradient-to-br {{
                                $package->type === 'omra' ? 'from-green-400 to-green-600' :
                                ($package->type === 'circuit' ? 'from-orange-400 to-orange-600' :
                                ($package->type === 'sejour' ? 'from-blue-400 to-blue-600' : 'from-purple-400 to-purple-600'))
                            }} flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-24 h-24 mx-auto opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="absolute top-2 left-2">
                                <span class="bg-white text-gray-900 px-3 py-1 rounded-full text-xs font-semibold uppercase">
                                    {{ $package->type }}
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $package->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $package->short_description }}</p>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $package->duration_days }} jours / {{ $package->duration_nights }} nuits
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ implode(', ', array_slice($package->destinations, 0, 2)) }}
                                    @if(count($package->destinations) > 2)
                                        <span class="text-gray-500">+{{ count($package->destinations) - 2 }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">À partir de</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($package->price_adult, 0) }} {{ $package->currency }}</p>
                                </div>
                                <a href="{{ route('packages.show', $package->slug) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150 ease-in-out text-sm font-semibold">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Reviews Section -->
    @if($recentReviews->isNotEmpty())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Avis de nos clients</h2>
                <p class="text-gray-600 mt-2">Découvrez les expériences de nos voyageurs</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentReviews->take(6) as $review)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-lg">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                <div class="flex items-center">
                                    @for($i = 0; $i < floor($review->rating); $i++)
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600">{{ number_format($review->rating, 1) }}/10</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 text-sm mb-3">{{ Str::limit($review->comment, 120) }}</p>
                        <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Why Choose Us Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Pourquoi nous choisir ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Meilleurs Prix</h3>
                    <p class="text-blue-100 text-sm">Prix compétitifs et transparents</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Programme Fidélité</h3>
                    <p class="text-blue-100 text-sm">Cumulez des points à chaque réservation</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Support 24/7</h3>
                    <p class="text-blue-100 text-sm">Service client disponible à tout moment</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Paiement Sécurisé</h3>
                    <p class="text-blue-100 text-sm">Plusieurs modes de paiement disponibles</p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
