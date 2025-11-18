@php
$faqs = [
    [
        'question' => 'Comment réserver un voyage?',
        'answer' => 'Parcourez nos offres, sélectionnez votre destination, choisissez vos dates et remplissez le formulaire de réservation. Vous recevrez une confirmation par email immédiatement.'
    ],
    [
        'question' => 'Quels modes de paiement acceptez-vous?',
        'answer' => 'Nous acceptons Stripe (cartes bancaires internationales), PayPal, et Flouci pour les paiements locaux en Tunisie. Tous les paiements sont 100% sécurisés.'
    ],
    [
        'question' => 'Puis-je annuler ou modifier ma réservation?',
        'answer' => 'Oui, vous pouvez annuler gratuitement jusqu\'à 48h avant le départ. Pour les modifications, contactez notre service client via WhatsApp ou le chat en ligne.'
    ],
    [
        'question' => 'Comment fonctionne le programme de fidélité?',
        'answer' => 'Gagnez des points à chaque réservation: Bronze (0-999 pts), Silver (1000-4999), Gold (5000-9999), Platinum (10000+). Plus votre niveau est élevé, plus vous bénéficiez de réductions et d\'avantages exclusifs.'
    ],
    [
        'question' => 'Les prix incluent-ils tous les frais?',
        'answer' => 'Oui, nos prix sont tout compris: hébergement, transport, assurance voyage de base. Seuls les extras personnels (excursions optionnelles, souvenirs) sont à votre charge.'
    ],
    [
        'question' => 'Comment utiliser un chèque cadeau?',
        'answer' => 'Lors de la réservation, entrez votre code chèque cadeau dans le champ prévu. Le montant sera automatiquement déduit. Le solde restant peut être utilisé pour vos prochaines réservations.'
    ],
    [
        'question' => 'Proposez-vous des assurances voyage?',
        'answer' => 'Oui, une assurance de base est incluse. Vous pouvez souscrire à une assurance premium avec annulation toutes causes lors de votre réservation.'
    ],
    [
        'question' => 'Quelle est votre politique COVID-19?',
        'answer' => 'Nous suivons strictement les protocoles sanitaires. Annulation gratuite en cas de restrictions de voyage. Tests PCR organisés si nécessaires. Équipe disponible 24/7 pour assistance.'
    ]
];
@endphp

<div class="bg-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Questions Fréquentes
            </h2>
            <p class="text-xl text-gray-600">
                Trouvez rapidement les réponses à vos questions
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div x-data="{ activeIndex: null }" class="space-y-4">
            @foreach($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-blue-300 transition">
                <button @click="activeIndex = activeIndex === {{ $index }} ? null : {{ $index }}"
                        class="w-full px-6 py-4 text-left flex items-center justify-between bg-white hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900 pr-4">{{ $faq['question'] }}</span>
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 transition-transform"
                         :class="{ 'rotate-180': activeIndex === {{ $index }} }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeIndex === {{ $index }}"
                     x-collapse
                     class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-gray-700">{{ $faq['answer'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact CTA -->
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-8 text-center border border-blue-100">
            <h3 class="text-xl font-bold text-gray-900 mb-3">Vous ne trouvez pas la réponse?</h3>
            <p class="text-gray-600 mb-6">Notre équipe est disponible 24/7 pour répondre à toutes vos questions</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tel:+21670123456" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Appelez-nous
                </a>
                <button onclick="Tawk_API.toggle()" class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-lg hover:bg-gray-50 transition font-semibold border-2 border-blue-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Chat en direct
                </button>
            </div>
        </div>
    </div>
</div>
