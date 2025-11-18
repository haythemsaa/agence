<x-public-layout>
    <x-slot name="title">Chèque Cadeau {{ $voucher->code }}</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
        <div class="mb-8 bg-green-50 border-l-4 border-green-400 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Voucher Card -->
        <div class="bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl shadow-2xl p-8 text-white mb-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Chèque Cadeau Voyage</h1>
                    <p class="text-pink-100">Agence de Voyage Tunisie</p>
                </div>
                <div class="text-right">
                    @if($voucher->isValid())
                        <span class="inline-block px-4 py-2 bg-green-500 rounded-full text-sm font-semibold">
                            ✓ Actif
                        </span>
                    @else
                        <span class="inline-block px-4 py-2 bg-gray-500 rounded-full text-sm font-semibold">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm mb-6">
                <div class="text-center">
                    <p class="text-sm text-pink-100 mb-2">Montant</p>
                    <p class="text-5xl font-bold">{{ number_format($voucher->remaining_balance, 2) }} <span class="text-2xl">{{ $voucher->currency }}</span></p>
                    @if($voucher->remaining_balance < $voucher->amount)
                        <p class="text-sm text-pink-100 mt-2">
                            (Montant initial: {{ number_format($voucher->amount, 2) }} {{ $voucher->currency }})
                        </p>
                    @endif
                </div>
            </div>

            <div class="border-t border-white border-opacity-30 pt-6">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    <p class="text-sm font-mono bg-white bg-opacity-20 px-4 py-2 rounded">{{ $voucher->code }}</p>
                </div>
                <p class="text-center text-sm text-pink-100">
                    Utilisez ce code lors de votre réservation
                </p>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Recipient Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Bénéficiaire
                </h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-600">Nom:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ $voucher->recipient_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ $voucher->recipient_email }}</span>
                    </div>
                </div>
            </div>

            <!-- Purchaser Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                    Offert par
                </h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-600">Nom:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ $voucher->purchaser_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Date d'achat:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ $voucher->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Validity Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Validité
                </h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-600">Expire le:</span>
                        <span class="font-semibold {{ $voucher->valid_until->isPast() ? 'text-red-600' : 'text-gray-900' }} ml-2">
                            {{ $voucher->valid_until->format('d/m/Y') }}
                        </span>
                    </div>
                    <div>
                        @if($voucher->isValid())
                            <span class="text-green-600 font-semibold">Encore {{ $voucher->valid_until->diffForHumans() }}</span>
                        @else
                            <span class="text-red-600 font-semibold">Expiré</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Statut
                </h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-600">État:</span>
                        <span class="font-semibold ml-2 {{ $voucher->status === 'active' ? 'text-green-600' : 'text-gray-600' }}">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    </div>
                    @if($voucher->redeemed_at)
                    <div>
                        <span class="text-gray-600">Utilisé le:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ $voucher->redeemed_at->format('d/m/Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Personal Message -->
        @if($voucher->personal_message)
        <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-lg p-6 mb-8 border-l-4 border-pink-500">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                Message personnel
            </h3>
            <p class="text-gray-700 italic">"{{ $voucher->personal_message }}"</p>
        </div>
        @endif

        <!-- How to Use -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Comment utiliser ce chèque cadeau?</h3>
            <div class="space-y-3 text-sm text-gray-700">
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">1</span>
                    <p>Parcourez nos hôtels et voyages organisés sur le site</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">2</span>
                    <p>Lors de la réservation, entrez le code <strong class="font-mono">{{ $voucher->code }}</strong> dans le champ prévu</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">3</span>
                    <p>Le montant sera automatiquement déduit de votre total</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">4</span>
                    <p>Si le montant du chèque est supérieur au prix, le solde reste disponible pour vos prochaines réservations</p>
                </div>
            </div>
        </div>

        <!-- CTA Buttons -->
        @if($voucher->isValid())
        <div class="mt-8 flex flex-wrap gap-4 justify-center">
            <a href="{{ route('hotels.index') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Réserver un Hôtel
            </a>
            <a href="{{ route('packages.index') }}" class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-md hover:bg-purple-700 transition font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Réserver un Voyage
            </a>
        </div>
        @endif
    </div>
</x-public-layout>
