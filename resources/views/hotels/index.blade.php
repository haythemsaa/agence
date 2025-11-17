<x-public-layout>
    <x-slot name="title">Réservation d'Hôtels en Tunisie</x-slot>

    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-4">Réservez votre hôtel en Tunisie</h1>
            <p class="text-xl text-blue-100">Les meilleurs hôtels aux meilleurs prix</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('hotels.search') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                        <select name="destination" id="destination" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Choisir une destination</option>
                            <option value="HAM">Hammamet</option>
                            <option value="SOU">Sousse</option>
                            <option value="DJE">Djerba</option>
                            <option value="TUN">Tunis</option>
                            <option value="MAH">Mahdia</option>
                            <option value="MON">Monastir</option>
                            <option value="TOZ">Tozeur</option>
                            <option value="TAB">Tabarka</option>
                        </select>
                    </div>
                    <div>
                        <label for="check_in" class="block text-sm font-medium text-gray-700 mb-1">Arrivée</label>
                        <input type="date" name="check_in" id="check_in" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="check_out" class="block text-sm font-medium text-gray-700 mb-1">Départ</label>
                        <input type="date" name="check_out" id="check_out" required min="{{ date('Y-m-d', strtotime('+2 days')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="adults" class="block text-sm font-medium text-gray-700 mb-1">Voyageurs</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="adults" id="adults" placeholder="Adultes" min="1" max="9" value="2" required class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <input type="number" name="children" placeholder="Enfants" min="0" max="9" value="0" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full md:w-auto bg-blue-600 text-white py-2 px-8 rounded-md font-semibold hover:bg-blue-700 transition duration-150 ease-in-out">
                    Rechercher
                </button>
            </form>
        </div>

        <!-- Popular Destinations -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Destinations populaires</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $popularDestinations = [
                        ['name' => 'Hammamet', 'code' => 'HAM', 'color' => 'from-blue-400 to-blue-600'],
                        ['name' => 'Djerba', 'code' => 'DJE', 'color' => 'from-green-400 to-green-600'],
                        ['name' => 'Sousse', 'code' => 'SOU', 'color' => 'from-purple-400 to-purple-600'],
                        ['name' => 'Monastir', 'code' => 'MON', 'color' => 'from-orange-400 to-orange-600'],
                    ];
                @endphp
                @foreach($popularDestinations as $dest)
                    <a href="{{ route('hotels.search', ['destination' => $dest['code'], 'check_in' => date('Y-m-d', strtotime('+7 days')), 'check_out' => date('Y-m-d', strtotime('+14 days')), 'adults' => 2]) }}" class="relative h-32 rounded-lg overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br {{ $dest['color'] }} group-hover:scale-105 transition-transform duration-300"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h3 class="text-white text-xl font-bold">{{ $dest['name'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Featured Hotels -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Hôtels recommandés</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($hotels as $hotel)
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

                            <!-- Wishlist Button -->
                            <x-wishlist-button type="hotel" :id="$hotel->id" />

                            @if($hotel->is_featured)
                                <div class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    Vedette
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-bold text-lg text-gray-900">{{ $hotel->name }}</h3>
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
                            @if(!empty($hotel->amenities))
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach(array_slice($hotel->amenities, 0, 3) as $amenity)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $amenity }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <a href="{{ route('hotels.show', $hotel->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-150 ease-in-out font-semibold">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">Aucun hôtel disponible pour le moment</p>
                        <p class="text-gray-400 text-sm mt-2">Utilisez le formulaire de recherche ci-dessus pour trouver des hôtels</p>
                    </div>
                @endforelse
            </div>

            @if($hotels->hasPages())
                <div class="mt-8">
                    {{ $hotels->links() }}
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
