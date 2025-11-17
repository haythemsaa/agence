<x-public-layout>
    <x-slot name="title">Résultats de recherche - Hôtels</x-slot>

    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-2">Résultats de recherche</h1>
            <p class="text-blue-100">
                {{ $total }} hôtel(s) trouvé(s)
                @if(isset($searchParams['destination']))
                    pour {{ $searchParams['destination'] ?? '' }}
                @endif
                du {{ \Carbon\Carbon::parse($searchParams['check_in'])->format('d/m/Y') }}
                au {{ \Carbon\Carbon::parse($searchParams['check_out'])->format('d/m/Y') }}
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Filtres</h2>

                    <form action="{{ route('hotels.search') }}" method="GET">
                        <!-- Preserve search params -->
                        <input type="hidden" name="destination" value="{{ $searchParams['destination'] ?? '' }}">
                        <input type="hidden" name="check_in" value="{{ $searchParams['check_in'] ?? '' }}">
                        <input type="hidden" name="check_out" value="{{ $searchParams['check_out'] ?? '' }}">
                        <input type="hidden" name="adults" value="{{ $searchParams['adults'] ?? 2 }}">
                        <input type="hidden" name="children" value="{{ $searchParams['children'] ?? 0 }}">

                        <!-- Star Rating Filter -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Catégorie</h3>
                            <div class="space-y-2">
                                @foreach([5, 4, 3] as $stars)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="stars[]" value="{{ $stars }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">
                                            @for($i = 0; $i < $stars; $i++)
                                                ⭐
                                            @endfor
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Prix par nuit</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="0-100" class="border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Moins de 100 TND</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="100-200" class="border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">100 - 200 TND</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price_range" value="200-" class="border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Plus de 200 TND</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-150 ease-in-out">
                            Appliquer les filtres
                        </button>
                    </form>

                    <a href="{{ route('hotels.search', $searchParams) }}" class="block w-full text-center text-sm text-gray-600 hover:text-gray-800 mt-4">
                        Réinitialiser les filtres
                    </a>
                </div>
            </div>

            <!-- Results -->
            <div class="lg:col-span-3">
                <!-- Modify Search Bar -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                    <form action="{{ route('hotels.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Destination</label>
                            <select name="destination" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">Choisir</option>
                                @foreach(['HAM' => 'Hammamet', 'SOU' => 'Sousse', 'DJE' => 'Djerba', 'TUN' => 'Tunis', 'MAH' => 'Mahdia', 'MON' => 'Monastir', 'TOZ' => 'Tozeur', 'TAB' => 'Tabarka'] as $code => $name)
                                    <option value="{{ $code }}" {{ ($searchParams['destination'] ?? '') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Arrivée</label>
                            <input type="date" name="check_in" value="{{ $searchParams['check_in'] ?? '' }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Départ</label>
                            <input type="date" name="check_out" value="{{ $searchParams['check_out'] ?? '' }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Voyageurs</label>
                            <input type="number" name="adults" value="{{ $searchParams['adults'] ?? 2 }}" min="1" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition text-sm font-semibold">
                            Modifier
                        </button>
                    </form>
                </div>

                <!-- Sorting -->
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm text-gray-600">{{ $total }} résultat(s)</p>
                    <div>
                        <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option>Trier par: Recommandé</option>
                            <option>Prix croissant</option>
                            <option>Prix décroissant</option>
                            <option>Note client</option>
                            <option>Catégorie</option>
                        </select>
                    </div>
                </div>

                <!-- Hotel Cards -->
                <div class="space-y-6">
                    @forelse($hotels as $hotel)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="md:flex">
                                <div class="md:flex-shrink-0 md:w-80">
                                    @if(!empty($hotel['images']) && count($hotel['images']) > 0)
                                        <img src="{{ $hotel['images'][0] }}" alt="{{ $hotel['name'] }}" class="h-full w-full object-cover md:h-64">
                                    @else
                                        <div class="h-full w-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center md:h-64">
                                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6 flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-1">
                                                @for($i = 0; $i < ($hotel['stars'] ?? 0); $i++)
                                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $hotel['name'] }}</h3>
                                            <p class="text-sm text-gray-600">📍 {{ $hotel['address'] ?? ($hotel['city'] . ', ' . $hotel['country']) }}</p>
                                        </div>
                                        @if(isset($hotel['rating']) && $hotel['rating'] > 0)
                                            <div class="text-right">
                                                <div class="bg-blue-600 text-white px-3 py-1 rounded font-bold text-lg">
                                                    {{ number_format($hotel['rating'], 1) }}
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">{{ $hotel['reviews_count'] ?? 0 }} avis</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if(!empty($hotel['amenities']))
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach(array_slice($hotel['amenities'], 0, 5) as $amenity)
                                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded flex items-center">
                                                    <svg class="w-3 h-3 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $amenity }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if(!empty($hotel['rooms']))
                                        <div class="mb-4">
                                            <p class="text-sm font-semibold text-gray-700 mb-2">Chambres disponibles:</p>
                                            <div class="space-y-2">
                                                @foreach(array_slice($hotel['rooms'], 0, 2) as $room)
                                                    <div class="flex justify-between items-center text-sm">
                                                        <span class="text-gray-700">{{ $room['name'] ?? 'Chambre Standard' }}</span>
                                                        <span class="font-semibold text-blue-600">{{ number_format($room['price'] ?? 0, 0) }} TND/nuit</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-end">
                                        <div>
                                            @if(isset($hotel['minPrice']))
                                                <p class="text-sm text-gray-600">À partir de</p>
                                                <p class="text-2xl font-bold text-blue-600">{{ number_format($hotel['minPrice'], 0) }} TND</p>
                                                <p class="text-xs text-gray-500">par nuit</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('hotels.show', $hotel['id']) }}?{{ http_build_query($searchParams) }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-150 ease-in-out font-semibold">
                                            Voir les détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-lg shadow-md">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600 text-lg mb-2">Aucun hôtel trouvé pour cette recherche</p>
                            <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
