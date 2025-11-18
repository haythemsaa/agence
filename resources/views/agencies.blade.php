<x-public-layout>
    <x-slot name="title">Nos Agences en Tunisie</x-slot>

    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-4">Nos Agences en Tunisie</h1>
            <p class="text-xl text-blue-100">38 points de vente à votre service à travers tout le pays</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Map Container -->
        <div class="mb-12">
            <div id="map" class="w-full h-[500px] rounded-lg shadow-lg"></div>
        </div>

        <!-- Agencies Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $agencies = [
                ['name' => 'Agence Tunis Centre-Ville', 'address' => 'Avenue Habib Bourguiba, Tunis 1000', 'phone' => '+216 71 123 456', 'lat' => 36.8065, 'lng' => 10.1815],
                ['name' => 'Agence La Marsa', 'address' => 'Rue de la République, La Marsa 2070', 'phone' => '+216 71 234 567', 'lat' => 36.8761, 'lng' => 10.3257],
                ['name' => 'Agence Ariana', 'address' => 'Centre Commercial Ariana, Ariana 2080', 'phone' => '+216 71 345 678', 'lat' => 36.8625, 'lng' => 10.1956],
                ['name' => 'Agence Sousse Médina', 'address' => 'Boulevard de la Corniche, Sousse 4000', 'phone' => '+216 73 123 456', 'lat' => 35.8256, 'lng' => 10.6369],
                ['name' => 'Agence Hammamet', 'address' => 'Avenue de la Paix, Hammamet 8050', 'phone' => '+216 72 234 567', 'lat' => 36.4040, 'lng' => 10.6188],
                ['name' => 'Agence Nabeul', 'address' => 'Avenue Farhat Hached, Nabeul 8000', 'phone' => '+216 72 345 678', 'lat' => 36.4511, 'lng' => 10.7357],
                ['name' => 'Agence Monastir', 'address' => 'Route de la Corniche, Monastir 5000', 'phone' => '+216 73 456 789', 'lat' => 35.7774, 'lng' => 10.8262],
                ['name' => 'Agence Mahdia', 'address' => 'Avenue Habib Bourguiba, Mahdia 5100', 'phone' => '+216 73 567 890', 'lat' => 35.5047, 'lng' => 11.0622],
                ['name' => 'Agence Sfax Centre', 'address' => 'Avenue Hedi Chaker, Sfax 3000', 'phone' => '+216 74 123 456', 'lat' => 34.7406, 'lng' => 10.7603],
                ['name' => 'Agence Djerba Houmt Souk', 'address' => 'Place Sidi Ibrahim, Houmt Souk 4180', 'phone' => '+216 75 123 456', 'lat' => 33.8751, 'lng' => 10.8578],
                ['name' => 'Agence Djerba Midoun', 'address' => 'Zone Touristique, Midoun 4116', 'phone' => '+216 75 234 567', 'lat' => 33.8097, 'lng' => 10.9925],
                ['name' => 'Agence Gabès', 'address' => 'Avenue Farhat Hached, Gabès 6000', 'phone' => '+216 75 345 678', 'lat' => 33.8815, 'lng' => 10.0982],
                ['name' => 'Agence Kairouan', 'address' => 'Avenue de la République, Kairouan 3100', 'phone' => '+216 77 123 456', 'lat' => 35.6781, 'lng' => 10.0963],
                ['name' => 'Agence Bizerte', 'address' => 'Avenue Habib Bourguiba, Bizerte 7000', 'phone' => '+216 72 456 789', 'lat' => 37.2746, 'lng' => 9.8739],
                ['name' => 'Agence Tabarka', 'address' => 'Avenue Habib Bourguiba, Tabarka 8110', 'phone' => '+216 78 123 456', 'lat' => 36.9544, 'lng' => 8.7583],
                ['name' => 'Agence Tozeur', 'address' => 'Avenue Abou el Kacem Chebbi, Tozeur 2200', 'phone' => '+216 76 123 456', 'lat' => 33.9197, 'lng' => 8.1335],
            ];
            @endphp

            @foreach($agencies as $agency)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition" data-lat="{{ $agency['lat'] }}" data-lng="{{ $agency['lng'] }}">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $agency['name'] }}</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $agency['address'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <a href="tel:{{ $agency['phone'] }}" class="text-blue-600 hover:text-blue-700">{{ $agency['phone'] }}</a>
                            </div>
                        </div>
                        <button onclick="focusOnAgency({{ $agency['lat'] }}, {{ $agency['lng'] }})"
                                class="mt-3 text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Voir sur la carte →
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact Info -->
        <div class="mt-12 bg-blue-50 rounded-lg p-8">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Une question? Contactez-nous</h2>
                <div class="flex flex-wrap justify-center gap-6 text-gray-700">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="font-semibold">+216 70 123 456</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-semibold">contact@agence-voyage.tn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize map centered on Tunisia
        const map = L.map('map').setView([34.0, 9.5], 7);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Agency data
        const agencies = @json($agencies);

        // Add markers for each agency
        agencies.forEach(agency => {
            const marker = L.marker([agency.lat, agency.lng]).addTo(map);
            marker.bindPopup(`
                <div class="text-sm">
                    <h3 class="font-bold mb-1">${agency.name}</h3>
                    <p class="text-gray-600 mb-1">${agency.address}</p>
                    <p class="text-blue-600">${agency.phone}</p>
                </div>
            `);
        });

        // Function to focus on specific agency
        function focusOnAgency(lat, lng) {
            map.setView([lat, lng], 13);
            // Scroll to map
            document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
</x-public-layout>
