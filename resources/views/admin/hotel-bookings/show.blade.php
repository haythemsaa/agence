<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails Réservation Hôtel #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $booking->hotel_name }}</h3>
                            <p class="text-gray-600">Référence: {{ $booking->booking_reference }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.hotel-bookings.edit', $booking) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                                Modifier
                            </a>
                            <a href="{{ route('admin.hotel-bookings.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg">
                                Retour
                            </a>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-3">Informations Hôtel</h4>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-gray-600">Destination</p>
                                    <p class="font-medium">{{ $booking->city }}, {{ $booking->country }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Check-in</p>
                                    <p class="font-medium">{{ $booking->check_in->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Check-out</p>
                                    <p class="font-medium">{{ $booking->check_out->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Nuits</p>
                                    <p class="font-medium">{{ $booking->check_in->diffInDays($booking->check_out) }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-3">Client</h4>
                            <div class="space-y-2">
                                @if($booking->user)
                                    <div>
                                        <p class="text-sm text-gray-600">Nom</p>
                                        <p class="font-medium">{{ $booking->user->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium">{{ $booking->user->email }}</p>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-sm text-gray-600">Nom</p>
                                        <p class="font-medium">{{ $booking->holder_name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium">{{ $booking->holder_email ?? 'N/A' }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-600">Voyageurs</p>
                                    <p class="font-medium">{{ $booking->nb_adults }} adulte(s), {{ $booking->nb_children }} enfant(s)</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <h4 class="font-semibold mb-3">Paiement</h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Montant Total</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($booking->total_price, 2) }} TND</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Statut</p>
                                    <p class="font-medium">
                                        <span class="px-3 py-1 rounded-full text-sm
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Réservé le</p>
                                    <p class="font-medium">{{ $booking->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
