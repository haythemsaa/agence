<x-public-layout>
    <x-slot name="title">{{ $hotel['name'] }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center space-x-2 text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-gray-700">Accueil</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('hotels.index') }}" class="hover:text-gray-700">Hôtels</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">{{ $hotel['name'] }}</li>
            </ol>
        </nav>

        <!-- Hotel Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <div class="flex items-center mb-2">
                        @for($i = 0; $i < ($hotel['stars'] ?? 0); $i++)
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $hotel['name'] }}</h1>
                    <p class="text-gray-600">📍 {{ $hotel['address'] ?? ($hotel['city'] . ', ' . $hotel['country']) }}</p>
                </div>
                @if(isset($hotel['rating']) && $hotel['rating'] > 0)
                    <div class="text-right">
                        <div class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-2xl">
                            {{ number_format($hotel['rating'], 1) }}
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $hotel['reviews_count'] ?? 0 }} avis</p>
                        <p class="text-sm text-green-600 font-semibold">Excellent</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Hotel Images Gallery -->
        @if(!empty($hotel['images']) && count($hotel['images']) > 0)
            <div class="mb-6" x-data="{ currentImage: 0 }">
                <div class="relative h-96 rounded-lg overflow-hidden mb-4">
                    @foreach($hotel['images'] as $index => $image)
                        <img x-show="currentImage === {{ $index }}"
                             src="{{ $image }}"
                             alt="{{ $hotel['name'] }}"
                             class="w-full h-full object-cover"
                             x-transition>
                    @endforeach

                    @if(count($hotel['images']) > 1)
                        <button @click="currentImage = currentImage > 0 ? currentImage - 1 : {{ count($hotel['images']) - 1 }}"
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button @click="currentImage = currentImage < {{ count($hotel['images']) - 1 }} ? currentImage + 1 : 0"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                </div>

                @if(count($hotel['images']) > 1)
                    <div class="grid grid-cols-5 gap-2">
                        @foreach($hotel['images'] as $index => $image)
                            @if($index < 5)
                                <button @click="currentImage = {{ $index }}"
                                        :class="currentImage === {{ $index }} ? 'ring-2 ring-blue-600' : ''"
                                        class="relative h-20 rounded overflow-hidden">
                                    <img src="{{ $image }}" alt="Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                    @if($index === 4 && count($hotel['images']) > 5)
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white font-semibold">
                                            +{{ count($hotel['images']) - 5 }}
                                        </div>
                                    @endif
                                </button>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                @if(!empty($hotel['description']))
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">À propos de cet hôtel</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $hotel['description'] }}</p>
                    </div>
                @endif

                <!-- Amenities -->
                @if(!empty($hotel['amenities']))
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Équipements et services</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($hotel['amenities'] as $amenity)
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm">{{ $amenity }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Available Rooms -->
                @if(!empty($hotel['rooms']))
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Chambres disponibles</h2>
                        <div class="space-y-4">
                            @foreach($hotel['rooms'] as $room)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $room['name'] ?? 'Chambre Standard' }}</h3>
                                            @if(!empty($room['description']))
                                                <p class="text-sm text-gray-600 mb-3">{{ $room['description'] }}</p>
                                            @endif
                                            @if(!empty($room['amenities']))
                                                <div class="flex flex-wrap gap-2 mb-3">
                                                    @foreach($room['amenities'] as $amenity)
                                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $amenity }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                {{ $room['capacity'] ?? '2 adultes' }}
                                            </div>
                                        </div>
                                        <div class="ml-4 text-right">
                                            <p class="text-sm text-gray-600 mb-1">Prix par nuit</p>
                                            <p class="text-2xl font-bold text-blue-600">{{ number_format($room['price'] ?? 0, 0) }} TND</p>
                                            <a href="{{ route('hotels.booking-form', [$hotel['id'], 'room' => $room['code'] ?? '']) }}{{ !empty(request()->all()) ? '?' . http_build_query(request()->all()) : '' }}"
                                               class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm font-semibold">
                                                Réserver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Reviews -->
                @if(!empty($hotel['reviews']) && count($hotel['reviews']) > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Avis des clients</h2>
                        <div class="space-y-4">
                            @foreach($hotel['reviews'] as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $review['user_name'] ?? 'Client' }}</p>
                                            <div class="flex items-center mt-1">
                                                @for($i = 0; $i < floor($review['rating']); $i++)
                                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $review['date'] ?? '' }}</p>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $review['comment'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Booking Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Réserver cet hôtel</h3>

                    <form action="{{ route('hotels.booking-form', $hotel['id']) }}" method="GET">
                        <div class="space-y-4">
                            <div>
                                <label for="check_in" class="block text-sm font-medium text-gray-700 mb-1">Date d'arrivée</label>
                                <input type="date"
                                       name="check_in"
                                       id="check_in"
                                       value="{{ request('check_in') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="check_out" class="block text-sm font-medium text-gray-700 mb-1">Date de départ</label>
                                <input type="date"
                                       name="check_out"
                                       id="check_out"
                                       value="{{ request('check_out') }}"
                                       min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                       required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="adults" class="block text-sm font-medium text-gray-700 mb-1">Adultes</label>
                                <input type="number"
                                       name="adults"
                                       id="adults"
                                       min="1"
                                       max="9"
                                       value="{{ request('adults', 2) }}"
                                       required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="children" class="block text-sm font-medium text-gray-700 mb-1">Enfants</label>
                                <input type="number"
                                       name="children"
                                       id="children"
                                       min="0"
                                       max="9"
                                       value="{{ request('children', 0) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="rooms" class="block text-sm font-medium text-gray-700 mb-1">Chambres</label>
                                <input type="number"
                                       name="rooms"
                                       id="rooms"
                                       min="1"
                                       max="9"
                                       value="{{ request('rooms', 1) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            @if(isset($hotel['minPrice']))
                                <div class="bg-blue-50 rounded-lg p-4 mt-4">
                                    <p class="text-sm text-gray-600 mb-1">Prix à partir de</p>
                                    <p class="text-3xl font-bold text-blue-600">{{ number_format($hotel['minPrice'], 0) }} TND</p>
                                    <p class="text-xs text-gray-500 mt-1">par nuit</p>
                                </div>
                            @endif

                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition duration-150 ease-in-out mt-4">
                                Vérifier les disponibilités
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-start text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Annulation gratuite jusqu'à 24h avant l'arrivée</span>
                        </div>
                        <div class="flex items-start text-sm text-gray-600 mt-2">
                            <svg class="w-5 h-5 mr-2 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Paiement sécurisé</span>
                        </div>
                        <div class="flex items-start text-sm text-gray-600 mt-2">
                            <svg class="w-5 h-5 mr-2 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Confirmation instantanée</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
