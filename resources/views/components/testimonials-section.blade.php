@props(['reviews' => []])

@php
$defaultReviews = [
    [
        'name' => 'Sarah Martinez',
        'avatar' => 'SM',
        'rating' => 5,
        'location' => 'Paris, France',
        'comment' => 'Séjour exceptionnel à Djerba! L\'équipe a été aux petits soins, l\'hôtel était magnifique et les excursions parfaitement organisées. Je recommande vivement!',
        'package' => 'Séjour Djerba 7 jours',
        'date' => '2024-11-10'
    ],
    [
        'name' => 'Ahmed Ben Ali',
        'avatar' => 'AB',
        'rating' => 5,
        'location' => 'Lyon, France',
        'comment' => 'Programme TRE parfait pour les Tunisiens de l\'étranger. Prix compétitifs, organisation impeccable. Merci pour cette belle expérience!',
        'package' => 'Package TRE Spécial',
        'date' => '2024-11-05'
    ],
    [
        'name' => 'Marie Dubois',
        'avatar' => 'MD',
        'rating' => 5,
        'location' => 'Marseille, France',
        'comment' => 'Circuit découverte fantastique! Guides experts, sites incroyables, tout était parfait. Un grand merci à toute l\'équipe.',
        'package' => 'Circuit Sud Tunisien',
        'date' => '2024-10-28'
    ],
    [
        'name' => 'Karim Trabelsi',
        'avatar' => 'KT',
        'rating' => 5,
        'location' => 'Tunis, Tunisie',
        'comment' => 'Service impeccable du début à la fin. La plateforme est intuitive et le programme de fidélité très avantageux!',
        'package' => 'Hôtel Hammamet 5*',
        'date' => '2024-10-15'
    ]
];

$displayReviews = !empty($reviews) ? $reviews : $defaultReviews;
@endphp

<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Ce que disent nos clients
            </h2>
            <p class="text-xl text-gray-600">
                Plus de 50,000 voyageurs satisfaits nous font confiance
            </p>
            <div class="flex justify-center items-center mt-4 gap-6">
                <div class="flex items-center">
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="ml-2 text-2xl font-bold text-gray-900">4.9/5</span>
                </div>
                <div class="text-gray-600">
                    <span class="font-semibold text-gray-900">2,341</span> avis vérifiés
                </div>
            </div>
        </div>

        <!-- Reviews Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($displayReviews as $review)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300">
                <!-- Header -->
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                        {{ $review['avatar'] }}
                    </div>
                    <div class="ml-3 flex-1">
                        <h4 class="font-semibold text-gray-900">{{ $review['name'] }}</h4>
                        <p class="text-xs text-gray-500">{{ $review['location'] }}</p>
                    </div>
                </div>

                <!-- Rating -->
                <div class="flex items-center mb-3">
                    @for($i = 0; $i < $review['rating']; $i++)
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    @endfor
                    <span class="ml-2 text-sm font-semibold text-gray-700">{{ $review['rating'] }}.0</span>
                </div>

                <!-- Comment -->
                <p class="text-sm text-gray-700 mb-4 line-clamp-4">
                    "{{ $review['comment'] }}"
                </p>

                <!-- Package Badge -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs text-blue-600 font-medium">{{ $review['package'] }}</span>
                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($review['date'])->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                Voir tous les avis
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
