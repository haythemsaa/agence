<x-public-layout>
    <x-slot name="title">{{ $package->title }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center space-x-2 text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-gray-700">Accueil</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('packages.index') }}" class="hover:text-gray-700">Voyages Organisés</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">{{ $package->title }}</li>
            </ol>
        </nav>

        <!-- Package Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-wrap items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold uppercase">
                            {{ $package->type }}
                        </span>
                        @if($package->is_featured)
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                ⭐ Vedette
                            </span>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $package->title }}</h1>
                    <p class="text-lg text-gray-600 mb-4">{{ $package->short_description }}</p>

                    <div class="flex flex-wrap gap-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">{{ $package->duration_days }} jours / {{ $package->duration_nights }} nuits</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Départ de <span class="font-medium">{{ $package->departure_city }}</span></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Groupe de {{ $package->min_participants }}-{{ $package->max_participants }} personnes</span>
                        </div>
                    </div>
                </div>

                @if($package->rating > 0)
                    <div class="text-right mt-4 lg:mt-0">
                        <div class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-2xl inline-block">
                            {{ number_format($package->rating, 1) }}
                        </div>
                        <p class="text-sm text-gray-600 mt-2">{{ $package->reviews_count }} avis</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $package->description }}</p>
                </div>

                <!-- Destinations -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Destinations visitées</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($package->destinations as $destination)
                            <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg font-medium">
                                📍 {{ $destination }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Itinerary -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Programme détaillé</h2>
                    <div class="space-y-4">
                        @foreach($package->itinerary as $day)
                            <div class="flex">
                                <div class="flex-shrink-0 w-20">
                                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center font-bold">
                                        J{{ $day['day'] }}
                                    </div>
                                </div>
                                <div class="flex-1 ml-4 pb-8 border-l-2 border-gray-200 pl-6 last:border-0">
                                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $day['title'] }}</h3>
                                    <p class="text-gray-700">{{ $day['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Included / Not Included -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Le prix comprend
                        </h3>
                        <ul class="space-y-2">
                            @foreach($package->included as $item)
                                <li class="flex items-start text-gray-700">
                                    <svg class="w-5 h-5 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Ne comprend pas
                        </h3>
                        <ul class="space-y-2">
                            @foreach($package->not_included as $item)
                                <li class="flex items-start text-gray-700">
                                    <svg class="w-5 h-5 mr-2 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Accommodation & Transport Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Hébergement</h3>
                        <div class="flex items-center mb-2">
                            <span class="text-gray-700">Type:</span>
                            <span class="ml-2 font-medium">{{ $package->accommodation_type }}</span>
                        </div>
                        @if($package->accommodation_stars)
                            <div class="flex items-center">
                                <span class="text-gray-700">Catégorie:</span>
                                <div class="ml-2 flex">
                                    @for($i = 0; $i < $package->accommodation_stars; $i++)
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Transport</h3>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($package->transport_type === 'Avion')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                @endif
                            </svg>
                            <span class="font-medium">{{ $package->transport_type }}</span>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                @if($package->reviews->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Avis des voyageurs</h2>
                        <div class="space-y-4">
                            @foreach($package->reviews->where('is_published', true)->take(5) as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                            <div class="flex items-center mt-1">
                                                @for($i = 0; $i < floor($review->rating); $i++)
                                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endfor
                                                <span class="ml-2 text-sm text-gray-600">{{ number_format($review->rating, 1) }}/10</span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                    @if($review->admin_response)
                                        <div class="mt-3 pl-4 border-l-2 border-blue-200 bg-blue-50 p-3 rounded">
                                            <p class="text-sm font-semibold text-blue-900">Réponse de l'agence:</p>
                                            <p class="text-sm text-blue-800 mt-1">{{ $review->admin_response }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Booking Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-2">À partir de</p>
                        <div class="flex items-end">
                            <p class="text-4xl font-bold text-blue-600">{{ number_format($package->price_adult, 0) }}</p>
                            <p class="text-lg text-gray-600 ml-2 mb-1">{{ $package->currency }}</p>
                        </div>
                        <p class="text-sm text-gray-500">par adulte</p>

                        @if($package->price_child)
                            <p class="text-sm text-gray-600 mt-3">
                                Enfant: <span class="font-semibold">{{ number_format($package->price_child, 0) }} {{ $package->currency }}</span>
                            </p>
                        @endif

                        @if($package->single_supplement)
                            <p class="text-sm text-gray-600">
                                Supplément chambre individuelle: <span class="font-semibold">{{ number_format($package->single_supplement, 0) }} {{ $package->currency }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- Available Dates -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Dates de départ</h3>
                        <div class="space-y-2">
                            @foreach($package->departure_dates as $date)
                                @php
                                    $availablePlaces = $package->getAvailablePlaces($date);
                                @endphp
                                <div class="flex justify-between items-center p-3 border border-gray-200 rounded-lg hover:border-blue-500 transition">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                        <p class="text-xs {{ $availablePlaces <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $availablePlaces }} places disponibles
                                        </p>
                                    </div>
                                    <a href="{{ route('packages.booking-form', [$package->slug, 'date' => $date]) }}"
                                       class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        Choisir
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('packages.booking-form', $package->slug) }}"
                       class="block w-full bg-blue-600 text-white py-3 rounded-md font-semibold text-center hover:bg-blue-700 transition duration-150 ease-in-out mb-4">
                        Réserver maintenant
                    </a>

                    <div class="space-y-2 text-xs text-gray-600">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Confirmation instantanée</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Paiement en plusieurs fois possible</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Annulation sous conditions</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Besoin d'aide ?</p>
                        <p class="text-sm font-semibold text-gray-900">📞 +216 XX XXX XXX</p>
                        <p class="text-sm text-gray-600">📧 contact@agence-voyage.tn</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
