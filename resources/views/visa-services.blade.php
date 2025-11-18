<x-public-layout>
    <x-slot name="title">Services de Visa</x-slot>

    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Services d'Obtention de Visa</h1>
            <p class="text-xl text-indigo-100">Nous vous accompagnons dans toutes vos démarches de visa</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @php
            $visaServices = [
                [
                    'country' => 'Schengen',
                    'icon' => '🇪🇺',
                    'duration' => '10-15 jours',
                    'price' => 'À partir de 150 TND',
                    'documents' => ['Passeport valide', 'Photo d\'identité', 'Attestation de travail', 'Relevé bancaire', 'Assurance voyage'],
                ],
                [
                    'country' => 'France',
                    'icon' => '🇫🇷',
                    'duration' => '7-10 jours',
                    'price' => 'À partir de 180 TND',
                    'documents' => ['Passeport valide', 'Photo d\'identité', 'Justificatif d\'hébergement', 'Relevé bancaire', 'Assurance voyage'],
                ],
                [
                    'country' => 'Royaume-Uni',
                    'icon' => '🇬🇧',
                    'duration' => '15-20 jours',
                    'price' => 'À partir de 200 TND',
                    'documents' => ['Passeport valide', 'Photo d\'identité', 'Preuve de fonds', 'Lettre d\'invitation', 'Assurance voyage'],
                ],
                [
                    'country' => 'USA',
                    'icon' => '🇺🇸',
                    'duration' => '20-30 jours',
                    'price' => 'À partir de 350 TND',
                    'documents' => ['Passeport valide', 'DS-160 complété', 'Photo spécifique', 'Preuve de liens', 'Rendez-vous ambassade'],
                ],
                [
                    'country' => 'Canada',
                    'icon' => '🇨🇦',
                    'duration' => '15-25 jours',
                    'price' => 'À partir de 250 TND',
                    'documents' => ['Passeport valide', 'Photo d\'identité', 'Preuve de fonds', 'Lettre d\'invitation', 'Biométrie'],
                ],
                [
                    'country' => 'Turquie',
                    'icon' => '🇹🇷',
                    'duration' => '3-5 jours',
                    'price' => 'À partir de 80 TND',
                    'documents' => ['Passeport valide', 'Photo d\'identité', 'Réservation hôtel', 'Billet d\'avion'],
                ],
            ];
            @endphp

            @foreach($visaServices as $service)
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                <div class="text-center mb-4">
                    <div class="text-6xl mb-3">{{ $service['icon'] }}</div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $service['country'] }}</h3>
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span><strong>Délai:</strong> {{ $service['duration'] }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span><strong>Prix:</strong> {{ $service['price'] }}</span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h4 class="font-semibold text-gray-900 mb-2 text-sm">Documents requis:</h4>
                    <ul class="space-y-1">
                        @foreach($service['documents'] as $doc)
                        <li class="text-xs text-gray-600 flex items-start">
                            <svg class="w-3 h-3 mr-1 mt-0.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $doc }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <button class="mt-6 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition font-semibold text-sm">
                    Demander ce visa
                </button>
            </div>
            @endforeach
        </div>

        <!-- Process Steps -->
        <div class="bg-gray-50 rounded-lg p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Comment ça marche?</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">1</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Consultation</h3>
                    <p class="text-sm text-gray-600">Nous évaluons votre dossier et déterminons vos besoins</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">2</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Préparation</h3>
                    <p class="text-sm text-gray-600">Nous vous assistons dans la collecte des documents requis</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">3</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Soumission</h3>
                    <p class="text-sm text-gray-600">Nous déposons votre demande auprès des autorités compétentes</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">4</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Obtention</h3>
                    <p class="text-sm text-gray-600">Vous recevez votre visa et pouvez voyager en toute tranquillité</p>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Pourquoi nous choisir?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Taux de réussite élevé</h3>
                        <p class="text-sm text-gray-600">95% de nos demandes sont approuvées</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Traitement rapide</h3>
                        <p class="text-sm text-gray-600">Délais optimisés pour chaque pays</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Accompagnement complet</h3>
                        <p class="text-sm text-gray-600">Suivi personnalisé de A à Z</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="mt-12 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg p-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Besoin d'aide pour votre visa?</h2>
            <p class="text-xl mb-6 text-indigo-100">Contactez nos experts dès maintenant</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tel:+21670123456" class="inline-flex items-center bg-white text-indigo-600 px-6 py-3 rounded-md font-semibold hover:bg-indigo-50 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    +216 70 123 456
                </a>
                <a href="mailto:visa@agence-voyage.tn" class="inline-flex items-center bg-white text-indigo-600 px-6 py-3 rounded-md font-semibold hover:bg-indigo-50 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    visa@agence-voyage.tn
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
