@php
    $stats = [
        'years' => config('app.years_experience', 15),
        'clients' => config('app.total_clients', 50000),
        'rating' => config('app.google_rating', 4.8),
        'reviews' => config('app.google_reviews', 2341),
    ];
@endphp

<div class="bg-gradient-to-r from-blue-50 to-blue-100 py-8 border-y border-blue-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Years Experience -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="font-bold text-2xl text-gray-900">{{ $stats['years'] }}+</div>
                <div class="text-sm text-gray-600">ans d'expérience</div>
            </div>

            <!-- Clients Served -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-full mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="font-bold text-2xl text-gray-900">{{ number_format($stats['clients']) }}+</div>
                <div class="text-sm text-gray-600">clients satisfaits</div>
            </div>

            <!-- Google Rating -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-500 text-white rounded-full mb-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <div class="font-bold text-2xl text-gray-900">{{ $stats['rating'] }}/5</div>
                <div class="text-sm text-gray-600">sur Google ({{ number_format($stats['reviews']) }} avis)</div>
            </div>

            <!-- Secure Payment -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-600 text-white rounded-full mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div class="font-bold text-2xl text-gray-900">100%</div>
                <div class="text-sm text-gray-600">Paiement sécurisé</div>
            </div>
        </div>

        <!-- Additional Badges -->
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-blue-200">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-xs font-semibold text-gray-700">Garantie Meilleur Prix</span>
            </div>

            <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-blue-200">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-xs font-semibold text-gray-700">Annulation Gratuite</span>
            </div>

            <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-blue-200">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-xs font-semibold text-gray-700">Support 24/7</span>
            </div>

            <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-blue-200">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-xs font-semibold text-gray-700">🌱 Éco-Responsable</span>
            </div>
        </div>
    </div>
</div>
