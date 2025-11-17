<x-public-layout>
    <x-slot name="title">Voyages Organisés</x-slot>

    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-4">Voyages Organisés</h1>
            <p class="text-xl text-blue-100">Circuits, Omra, séjours all-inclusive et destinations internationales</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Tabs -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('packages.index') }}"
                   class="{{ !request('type') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} px-6 py-2 rounded-lg font-medium transition shadow-sm">
                    Tous
                </a>
                <a href="{{ route('packages.index', ['type' => 'circuit']) }}"
                   class="{{ request('type') === 'circuit' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} px-6 py-2 rounded-lg font-medium transition shadow-sm">
                    Circuits
                </a>
                <a href="{{ route('packages.index', ['type' => 'sejour']) }}"
                   class="{{ request('type') === 'sejour' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} px-6 py-2 rounded-lg font-medium transition shadow-sm">
                    Séjours
                </a>
                <a href="{{ route('packages.index', ['type' => 'omra']) }}"
                   class="{{ request('type') === 'omra' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} px-6 py-2 rounded-lg font-medium transition shadow-sm">
                    Omra
                </a>
                <a href="{{ route('packages.index', ['type' => 'international']) }}"
                   class="{{ request('type') === 'international' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} px-6 py-2 rounded-lg font-medium transition shadow-sm">
                    International
                </a>
            </div>
        </div>

        <!-- Search and Sort -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-8">
            <form action="{{ route('packages.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif

                <div class="flex-1 min-w-[200px]">
                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                    <input type="text" name="destination" id="destination" value="{{ request('destination') }}"
                           placeholder="Ex: Djerba, Istanbul, Médine..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="w-48">
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Durée</label>
                    <select name="duration" id="duration" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Toutes durées</option>
                        <option value="1-3" {{ request('duration') === '1-3' ? 'selected' : '' }}>1-3 jours</option>
                        <option value="4-7" {{ request('duration') === '4-7' ? 'selected' : '' }}>4-7 jours</option>
                        <option value="8-" {{ request('duration') === '8-' ? 'selected' : '' }}>8+ jours</option>
                    </select>
                </div>

                <div class="w-48">
                    <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Prix max</label>
                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                           placeholder="TND"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-medium transition">
                    Filtrer
                </button>

                @if(request()->hasAny(['destination', 'duration', 'max_price']))
                    <a href="{{ route('packages.index', ['type' => request('type')]) }}"
                       class="text-sm text-gray-600 hover:text-gray-800 px-4 py-2">
                        Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        <!-- Package Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($packages as $package)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col">
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
                        <div class="absolute top-3 left-3">
                            <span class="bg-white text-gray-900 px-3 py-1 rounded-full text-xs font-semibold uppercase">
                                {{ $package->type }}
                            </span>
                        </div>
                        @if($package->is_featured)
                            <div class="absolute top-3 right-3">
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    ⭐ Vedette
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2">{{ $package->title }}</h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $package->short_description }}</p>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $package->duration_days }} jours / {{ $package->duration_nights }} nuits</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="truncate">{{ implode(', ', array_slice($package->destinations, 0, 2)) }}
                                    @if(count($package->destinations) > 2)
                                        <span class="text-gray-500">+{{ count($package->destinations) - 2 }}</span>
                                    @endif
                                </span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Départ de {{ $package->departure_city }}</span>
                            </div>

                            @if($package->rating > 0)
                                <div class="flex items-center">
                                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold">{{ number_format($package->rating, 1) }}</span>
                                    <span class="ml-2 text-xs text-gray-600">({{ $package->reviews_count }} avis)</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-200">
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">À partir de</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        {{ number_format($package->price_adult, 0) }} <span class="text-sm">{{ $package->currency }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500">par personne</p>
                                </div>
                                <a href="{{ route('packages.show', $package->slug) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm font-semibold whitespace-nowrap">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-600 text-lg mb-2">Aucun voyage trouvé</p>
                    <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
                </div>
            @endforelse
        </div>

        @if($packages->hasPages())
            <div class="mt-8">
                {{ $packages->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Why Book Packages Section -->
    <div class="bg-gray-50 py-16 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Pourquoi choisir nos voyages organisés ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Tout inclus</h3>
                    <p class="text-gray-600 text-sm">Transport, hébergement, repas et visites guidées</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Groupes conviviaux</h3>
                    <p class="text-gray-600 text-sm">Voyagez en petits groupes pour une expérience authentique</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Paiement flexible</h3>
                    <p class="text-gray-600 text-sm">Possibilité de payer en plusieurs fois</p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
