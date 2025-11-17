<x-public-layout>
    <x-slot name="title">Paiement Annulé</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement Annulé</h1>
            <p class="text-lg text-gray-600 mb-8">
                Votre paiement a été annulé. Aucun montant n'a été débité.
            </p>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <p class="text-sm text-gray-600">
                    Votre réservation est toujours en attente. Vous pouvez réessayer de payer à tout moment.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                    Voir mes réservations
                </a>
                <a href="{{ route('home') }}" class="inline-block bg-gray-200 text-gray-700 px-8 py-3 rounded-md hover:bg-gray-300 transition font-semibold">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
