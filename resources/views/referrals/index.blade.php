<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Programme de Parrainage
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg shadow-lg p-8 text-white mb-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-6 md:mb-0">
                        <h1 class="text-3xl font-bold mb-2">Parrainez vos amis et gagnez 50 TND!</h1>
                        <p class="text-green-100 text-lg">Pour chaque ami qui effectue une réservation</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 rounded-full w-32 h-32 flex items-center justify-center mb-2">
                            <span class="text-5xl font-bold">50</span>
                        </div>
                        <p class="text-sm font-semibold">TND par ami</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Parrainages</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->referrals_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Parrainages Validés</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->successful_referrals_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Gagné</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format((auth()->user()->successful_referrals_count ?? 0) * 50, 0) }} TND</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referral Code Card -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Votre Code de Parrainage</h2>
                <div class="bg-gray-50 rounded-lg p-6 border-2 border-dashed border-gray-300">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="mb-4 md:mb-0">
                            <p class="text-sm text-gray-600 mb-2">Partagez ce code avec vos amis:</p>
                            <div class="flex items-center">
                                <code class="text-3xl font-bold text-green-600 font-mono">{{ auth()->user()->referral_code ?? 'LOADING...' }}</code>
                                <button onclick="copyReferralCode()" class="ml-4 p-2 bg-gray-200 hover:bg-gray-300 rounded-md transition">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-2">Ou partagez le lien:</p>
                            <a href="{{ route('register') }}?ref={{ auth()->user()->referral_code }}"
                               class="text-blue-600 hover:text-blue-700 text-sm underline break-all">
                                {{ route('register') }}?ref={{ auth()->user()->referral_code }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How It Works -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Comment ça marche?</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">1</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Partagez</h3>
                        <p class="text-sm text-gray-600">Envoyez votre code de parrainage à vos amis</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">2</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Inscription</h3>
                        <p class="text-sm text-gray-600">Votre ami s'inscrit avec votre code</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">2</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Réservation</h3>
                        <p class="text-sm text-gray-600">Il effectue sa première réservation</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold">4</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Récompense</h3>
                        <p class="text-sm text-gray-600">Vous recevez 50 TND de crédit!</p>
                    </div>
                </div>
            </div>

            <!-- Share Buttons -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Partagez sur vos réseaux</h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <button class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                        Facebook
                    </button>
                    <button class="inline-flex items-center bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition">
                        WhatsApp
                    </button>
                    <button class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-md hover:bg-gray-700 transition">
                        Email
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyReferralCode() {
            const code = '{{ auth()->user()->referral_code ?? '' }}';
            navigator.clipboard.writeText(code).then(() => {
                alert('Code copié dans le presse-papier!');
            });
        }
    </script>
</x-app-layout>
