<x-public-layout>
    <x-slot name="title">Paiement Réussi</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement Réussi !</h1>
            <p class="text-lg text-gray-600 mb-8">
                Votre paiement a été traité avec succès.
            </p>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="text-left">
                        <p class="text-gray-500">Référence de paiement</p>
                        <p class="font-semibold text-gray-900">#{{ $payment->id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500">Montant payé</p>
                        <p class="font-semibold text-green-600 text-xl">{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</p>
                    </div>
                    <div class="text-left">
                        <p class="text-gray-500">Méthode</p>
                        <p class="font-semibold text-gray-900">{{ ucfirst($payment->payment_method) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500">Date</p>
                        <p class="font-semibold text-gray-900">{{ $payment->paid_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <p class="text-gray-600">
                    Un email de confirmation vous a été envoyé avec tous les détails de votre réservation.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                        Voir mes réservations
                    </a>
                    <a href="{{ route('home') }}" class="inline-block bg-gray-200 text-gray-700 px-8 py-3 rounded-md hover:bg-gray-300 transition font-semibold">
                        Retour à l'accueil
                    </a>
                </div>
            </div>

            @auth
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-green-900 font-semibold mb-2">🌟 Points de fidélité gagnés !</p>
                        <p class="text-green-700 text-sm">
                            Vous avez gagné {{ number_format($payment->amount, 0) }} points de fidélité.
                        </p>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</x-public-layout>
