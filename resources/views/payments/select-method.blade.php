<x-public-layout>
    <x-slot name="title">Choisir le mode de paiement</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Choisissez votre mode de paiement</h1>
            <p class="text-gray-600 mb-8">Sélectionnez la méthode de paiement qui vous convient</p>

            <form action="{{ route('payment.initiate') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_type" value="{{ session('booking_type') }}">
                <input type="hidden" name="booking_id" value="{{ session('booking_id') }}">
                <input type="hidden" name="amount" value="{{ $amount }}">

                <div class="space-y-4">
                    <!-- Stripe/Carte bancaire -->
                    <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="payment_method" value="stripe" required class="w-5 h-5 text-blue-600">
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">Carte Bancaire</p>
                                    <p class="text-sm text-gray-600">Visa, Mastercard, American Express</p>
                                </div>
                                <div class="flex space-x-2">
                                    <svg class="h-8 w-auto" viewBox="0 0 48 32"><rect fill="#1434CB" width="48" height="32" rx="4"/><path d="M17.5 11.5h13v9h-13z" fill="#EB001B"/><path d="M18 16a6 6 0 0 1 2.5-4.8 6 6 0 1 0 0 9.6 6 6 0 0 1-2.5-4.8z" fill="#FF5F00"/></svg>
                                    <svg class="h-8 w-auto" viewBox="0 0 48 32"><rect fill="#0066B2" width="48" height="32" rx="4"/><path d="M18 20.8c-2.7 0-4.8-2.1-4.8-4.8s2.1-4.8 4.8-4.8c.9 0 1.7.2 2.4.7l-1 1.7c-.4-.3-1-.5-1.5-.5-1.6 0-2.8 1.3-2.8 2.9s1.2 2.9 2.8 2.9c.5 0 1.1-.2 1.5-.5l1 1.7c-.6.4-1.4.7-2.4.7z" fill="#FFF"/></svg>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- PayPal -->
                    <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="payment_method" value="paypal" class="w-5 h-5 text-blue-600">
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">PayPal</p>
                                    <p class="text-sm text-gray-600">Payez avec votre compte PayPal</p>
                                </div>
                                <svg class="h-8 w-auto" viewBox="0 0 124 33"><path fill="#003087" d="M46.211 6.749h-6.839c-.468 0-.866.34-.939.803l-2.766 17.537c-.055.346.213.658.564.658h3.265c.468 0 .866-.34.939-.803l.746-4.73c.072-.463.471-.803.938-.803h2.165c4.505 0 7.105-2.18 7.784-6.5.306-1.89.013-3.375-.872-4.415-.972-1.142-2.696-1.746-4.985-1.746zM47 13.154c-.374 2.454-2.249 2.454-4.062 2.454h-1.032l.724-4.583c.043-.277.283-.481.563-.481h.473c1.235 0 2.4 0 3.002.704.359.42.468 1.044.332 1.906z"/><path fill="#009cde" d="M66.654 13.075h-3.275c-.279 0-.52.204-.563.481l-.145.916-.229-.332c-.709-1.029-2.29-1.373-3.868-1.373-3.619 0-6.71 2.741-7.312 6.586-.313 1.918.132 3.752 1.22 5.031.998 1.176 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91c-.055.348.213.66.562.66h2.95c.469 0 .865-.34.939-.803l1.77-11.209c.055-.347-.214-.659-.562-.659zm-4.565 6.374c-.316 1.871-1.801 3.127-3.695 3.127-.951 0-1.711-.305-2.199-.883-.484-.574-.668-1.391-.514-2.301.295-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.499.589.697 1.411.554 2.317z"/><path fill="#003087" d="M84.096 13.075h-3.291c-.314 0-.609.156-.787.417l-4.539 6.686-1.924-6.425c-.121-.402-.492-.678-.912-.678h-3.234c-.393 0-.666.384-.541.754l3.625 10.638-3.408 4.811c-.268.379.002.9.465.9h3.287c.312 0 .604-.152.781-.408l10.946-15.8c.267-.378-.002-.895-.468-.895z"/><path fill="#009cde" d="M94.992 6.749h-6.84c-.467 0-.865.34-.938.803l-2.766 17.537c-.055.346.213.658.562.658h3.51c.326 0 .605-.238.656-.562l.785-4.971c.072-.463.471-.803.938-.803h2.164c4.506 0 7.105-2.18 7.785-6.5.307-1.89.012-3.375-.873-4.415-.971-1.142-2.694-1.746-4.983-1.746zm.789 6.405c-.373 2.454-2.248 2.454-4.062 2.454h-1.031l.725-4.583c.043-.277.281-.481.562-.481h.473c1.234 0 2.4 0 3.002.704.359.42.468 1.044.331 1.906z"/><path fill="#009cde" d="M115.434 13.075h-3.273c-.281 0-.52.204-.562.481l-.145.916-.23-.332c-.709-1.029-2.289-1.373-3.867-1.373-3.619 0-6.709 2.741-7.311 6.586-.312 1.918.131 3.752 1.219 5.031 1 1.176 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91c-.055.348.213.66.564.66h2.949c.467 0 .865-.34.938-.803l1.771-11.209c.055-.347-.213-.659-.564-.659zm-4.565 6.374c-.314 1.871-1.801 3.127-3.695 3.127-.949 0-1.711-.305-2.199-.883-.484-.574-.666-1.391-.514-2.301.297-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.501.589.699 1.411.554 2.317z"/></svg>
                            </div>
                        </div>
                    </label>

                    <!-- Flouci (Tunisie) -->
                    <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="payment_method" value="flouci" class="w-5 h-5 text-blue-600">
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">Flouci</p>
                                    <p class="text-sm text-gray-600">Paiement mobile en Tunisie</p>
                                </div>
                                <div class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    TN
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Virement bancaire -->
                    <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-blue-600">
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">Virement Bancaire</p>
                                    <p class="text-sm text-gray-600">Instructions par email</p>
                                </div>
                                <svg class="h-8 w-auto text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 4H5c-1.11 0-2 .9-2 2v12c0 1.1.89 2 2 2h14c1.11 0 2-.9 2-2V6c0-1.1-.89-2-2-2zm0 14H5v-6h14v6zm0-10H5V6h14v2z"/>
                                </svg>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700">Montant à payer:</span>
                        <span class="text-3xl font-bold text-blue-600">{{ number_format($amount, 2) }} TND</span>
                    </div>
                    <p class="text-sm text-gray-500 text-center mt-2">
                        Paiement sécurisé - Vos informations sont protégées
                    </p>
                </div>

                <div class="mt-8 flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-semibold">
                        Retour
                    </a>
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">
                        Continuer vers le paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
