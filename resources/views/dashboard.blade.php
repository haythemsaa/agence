<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Réservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Loyalty Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">{{ auth()->user()->name }}</h3>
                        <p class="text-blue-100">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-block px-4 py-2 rounded-lg {{
                            auth()->user()->loyalty_level === 'platinum' ? 'bg-purple-500' :
                            (auth()->user()->loyalty_level === 'gold' ? 'bg-yellow-500' :
                            (auth()->user()->loyalty_level === 'silver' ? 'bg-gray-300 text-gray-900' : 'bg-orange-500'))
                        }} font-bold text-lg">
                            {{ strtoupper(auth()->user()->loyalty_level) }}
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Points de fidélité</p>
                        <p class="text-3xl font-bold">{{ number_format(auth()->user()->loyalty_points) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100 text-sm">Niveau suivant:</p>
                        <p class="font-semibold">
                            @if(auth()->user()->loyalty_level === 'bronze')
                                Silver - {{ 1000 - auth()->user()->loyalty_points }} pts
                            @elseif(auth()->user()->loyalty_level === 'silver')
                                Gold - {{ 2500 - auth()->user()->loyalty_points }} pts
                            @elseif(auth()->user()->loyalty_level === 'gold')
                                Platinum - {{ 5000 - auth()->user()->loyalty_points }} pts
                            @else
                                Niveau maximum atteint!
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Hôtels</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ auth()->user()->hotelBookings()->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Voyages</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ auth()->user()->packageBookings()->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">En cours</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ auth()->user()->hotelBookings()->whereIn('status', ['pending', 'confirmed'])->count() +
                                   auth()->user()->packageBookings()->whereIn('status', ['pending', 'confirmed'])->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Avis postés</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ auth()->user()->reviews()->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" x-data="{ tab: 'hotels' }">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex">
                        <button @click="tab = 'hotels'"
                                :class="tab === 'hotels' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm transition">
                            Réservations d'hôtels
                        </button>
                        <button @click="tab = 'packages'"
                                :class="tab === 'packages' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm transition">
                            Voyages organisés
                        </button>
                    </nav>
                </div>

                <!-- Hotel Bookings Tab -->
                <div x-show="tab === 'hotels'" class="p-6">
                    @forelse(auth()->user()->hotelBookings()->latest()->get() as $booking)
                        <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $booking->hotel_name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">📍 {{ $booking->city }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        Réservation #{{ $booking->booking_reference }}
                                    </p>
                                </div>
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{
                                        $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                        ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                                    }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-3">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Check-in</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->check_in->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Check-out</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->check_out->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Voyageurs</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->nb_adults }} adulte(s)</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Prix total</p>
                                    <p class="font-bold text-blue-600">{{ number_format($booking->total_price, 0) }} TND</p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Voir les détails</a>
                                @if($booking->status === 'confirmed' && !$booking->reviews()->where('user_id', auth()->id())->exists())
                                    <a href="#" class="text-sm text-green-600 hover:text-green-700 font-medium">Laisser un avis</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400">Aucune réservation d'hôtel</p>
                            <a href="{{ route('hotels.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-medium">
                                Réserver un hôtel
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Package Bookings Tab -->
                <div x-show="tab === 'packages'" class="p-6">
                    @forelse(auth()->user()->packageBookings()->with('package')->latest()->get() as $booking)
                        <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $booking->package->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $booking->package->duration_days }}j/{{ $booking->package->duration_nights }}n
                                        - {{ implode(', ', array_slice($booking->package->destinations, 0, 2)) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        Réservation #{{ $booking->booking_reference }}
                                    </p>
                                </div>
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{
                                        $booking->status === 'confirmed' || $booking->status === 'paid' ? 'bg-green-100 text-green-800' :
                                        ($booking->status === 'pending' || $booking->status === 'partially_paid' ? 'bg-yellow-100 text-yellow-800' :
                                        ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                                    }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-3">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Départ</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->departure_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Participants</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $booking->nb_adults }} adulte(s)
                                        @if($booking->nb_children > 0)
                                            , {{ $booking->nb_children }} enfant(s)
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Prix total</p>
                                    <p class="font-bold text-blue-600">{{ number_format($booking->total_price, 0) }} TND</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Payé / Restant</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ number_format($booking->paid_amount, 0) }} /
                                        <span class="{{ $booking->remaining_amount > 0 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ number_format($booking->remaining_amount, 0) }} TND
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('packages.show', $booking->package->slug) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Voir les détails</a>
                                @if($booking->remaining_amount > 0 && in_array($booking->status, ['confirmed', 'partially_paid']))
                                    <a href="#" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Payer le reste</a>
                                @endif
                                @if($booking->status === 'paid' && !$booking->package->reviews()->where('user_id', auth()->id())->exists())
                                    <a href="#" class="text-sm text-green-600 hover:text-green-700 font-medium">Laisser un avis</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400">Aucun voyage réservé</p>
                            <a href="{{ route('packages.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-medium">
                                Découvrir nos voyages
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
