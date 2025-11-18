<x-public-layout>
    <x-slot name="title">Chèques Cadeaux Voyage</x-slot>

    <div class="bg-gradient-to-r from-pink-500 to-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Offrez le Cadeau du Voyage</h1>
            <p class="text-xl text-pink-100">Chèques cadeaux pour hôtels, circuits et voyages organisés</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Benefits -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Cadeau Parfait</h3>
                <p class="text-gray-600 text-sm">Pour toutes les occasions</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Flexible</h3>
                <p class="text-gray-600 text-sm">Utilisable sur tous nos services</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Validité Longue</h3>
                <p class="text-gray-600 text-sm">Jusqu'à 24 mois</p>
            </div>
        </div>

        <!-- Purchase Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Créer un Chèque Cadeau</h2>

            <form action="{{ route('gift-vouchers.purchase') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Preset Amounts -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Montant</label>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        @foreach($presetAmounts as $preset)
                            <button type="button" onclick="document.getElementById('amount').value = {{ $preset }}"
                                    class="px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-pink-500 hover:bg-pink-50 transition text-center">
                                <span class="font-bold text-lg">{{ $preset }}</span>
                                <span class="text-sm text-gray-600">TND</span>
                            </button>
                        @endforeach
                    </div>
                    <div class="flex items-center">
                        <input type="number" name="amount" id="amount" min="50" max="10000" step="10" required
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                               placeholder="Ou entrez un montant personnalisé">
                        <span class="ml-3 text-gray-600 font-semibold">TND</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimum: 50 TND - Maximum: 10,000 TND</p>
                </div>

                <!-- Validity -->
                <div>
                    <label for="validity_months" class="block text-sm font-medium text-gray-700 mb-1">Validité</label>
                    <select name="validity_months" id="validity_months" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <option value="6">6 mois</option>
                        <option value="12" selected>12 mois</option>
                        <option value="24">24 mois</option>
                    </select>
                </div>

                <!-- Recipient Info -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations du Bénéficiaire</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" name="recipient_name" id="recipient_name" required
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        </div>
                        <div>
                            <label for="recipient_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="recipient_email" id="recipient_email" required
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        </div>
                    </div>
                </div>

                <!-- Personal Message -->
                <div>
                    <label for="personal_message" class="block text-sm font-medium text-gray-700 mb-1">
                        Message personnel (optionnel)
                    </label>
                    <textarea name="personal_message" id="personal_message" rows="3" maxlength="500"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                              placeholder="Ajoutez un message personnel pour le bénéficiaire..."></textarea>
                    <p class="mt-1 text-xs text-gray-500">Maximum 500 caractères</p>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 px-6 rounded-md font-semibold hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition">
                        Acheter le Chèque Cadeau
                    </button>
                </div>
            </form>
        </div>

        <!-- How it works -->
        <div class="mt-12 bg-gray-50 rounded-lg p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Comment ça marche?</h3>
            <div class="space-y-3 text-gray-700">
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                    <p>Choisissez le montant et remplissez les informations du bénéficiaire</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                    <p>Le bénéficiaire reçoit le chèque cadeau par email avec un code unique</p>
                </div>
                <div class="flex items-start">
                    <span class="flex-shrink-0 w-6 h-6 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                    <p>Le code peut être utilisé lors de la réservation d'un hôtel ou d'un voyage</p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
