<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Utilisateur: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Informations personnelles -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                            Modifier
                        </a>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Téléphone</p>
                            <p class="font-semibold">{{ $user->phone ?? 'Non renseigné' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Niveau de Fidélité</p>
                            <p class="font-semibold text-lg">{{ strtoupper($user->loyalty_level) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Points de Fidélité</p>
                            <p class="font-semibold text-xl text-blue-600">{{ $user->loyalty_points }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Membre depuis</p>
                            <p class="font-semibold">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Réservations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="font-semibold text-lg mb-4">Historique des Réservations</h4>
                    
                    @if($user->hotelBookings->count() > 0 || $user->packageBookings->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->hotelBookings as $booking)
                                <div class="border-l-4 border-blue-500 pl-4 py-2">
                                    <p class="font-medium">🏨 {{ $booking->hotel_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->check_in->format('d/m/Y') }} - {{ $booking->check_out->format('d/m/Y') }}</p>
                                    <p class="text-sm"><span class="font-semibold">{{ number_format($booking->total_price, 2) }} TND</span> - {{ ucfirst($booking->status) }}</p>
                                </div>
                            @endforeach

                            @foreach($user->packageBookings as $booking)
                                <div class="border-l-4 border-green-500 pl-4 py-2">
                                    <p class="font-medium">✈️ {{ $booking->package->title }}</p>
                                    <p class="text-sm text-gray-600">Départ: {{ $booking->departure_date->format('d/m/Y') }}</p>
                                    <p class="text-sm"><span class="font-semibold">{{ number_format($booking->total_price, 2) }} TND</span> - {{ ucfirst($booking->status) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucune réservation</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
