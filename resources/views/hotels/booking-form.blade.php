<x-public-layout>
    <x-slot name="title">Réservation - {{ $hotel['name'] }}</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-semibold">
                        1
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">Détails</span>
                </div>
                <div class="w-16 h-1 bg-gray-300 mx-4"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-semibold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-600">Paiement</span>
                </div>
                <div class="w-16 h-1 bg-gray-300 mx-4"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-semibold">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-600">Confirmation</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Détails de la réservation</h2>

                    <form action="{{ route('hotels.book') }}" method="POST" x-data="bookingForm()">
                        @csrf

                        <!-- Hidden fields -->
                        <input type="hidden" name="hotel_id" value="{{ $hotel['id'] }}">
                        <input type="hidden" name="check_in" value="{{ $searchParams['check_in'] }}">
                        <input type="hidden" name="check_out" value="{{ $searchParams['check_out'] }}">
                        <input type="hidden" name="adults" value="{{ $searchParams['adults'] }}">
                        <input type="hidden" name="children" value="{{ $searchParams['children'] ?? 0 }}">
                        <input type="hidden" name="room_code" value="{{ request('room') }}">
                        <input type="hidden" name="rate_key" value="{{ request('rate_key') }}">

                        <!-- Contact Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de contact</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="holder_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nom complet <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="holder_name" id="holder_name" required
                                           value="{{ auth()->user()->name ?? old('holder_name') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('holder_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="holder_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="holder_email" id="holder_email" required
                                           value="{{ auth()->user()->email ?? old('holder_email') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('holder_email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="holder_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Téléphone <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="holder_phone" id="holder_phone" required
                                           value="{{ auth()->user()->phone ?? old('holder_phone') }}"
                                           placeholder="+216 XX XXX XXX"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('holder_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="holder_country" class="block text-sm font-medium text-gray-700 mb-1">
                                        Pays <span class="text-red-500">*</span>
                                    </label>
                                    <select name="holder_country" id="holder_country" required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="TN" {{ (auth()->user()->country ?? old('holder_country')) == 'TN' ? 'selected' : '' }}>Tunisie</option>
                                        <option value="FR">France</option>
                                        <option value="DZ">Algérie</option>
                                        <option value="MA">Maroc</option>
                                        <option value="LY">Libye</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Details -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails des voyageurs</h3>

                            @for($i = 1; $i <= $searchParams['adults']; $i++)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="font-medium text-gray-700 mb-3">Adulte {{ $i }}</p>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                            <input type="text" name="guests[{{ $i-1 }}][first_name]" required
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                            <input type="text" name="guests[{{ $i-1 }}][last_name]" required
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                            <input type="text" value="Adulte" readonly
                                                   class="w-full rounded-md border-gray-300 bg-gray-100 cursor-not-allowed">
                                            <input type="hidden" name="guests[{{ $i-1 }}][type]" value="adult">
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            @if(isset($searchParams['children']) && $searchParams['children'] > 0)
                                @for($i = 1; $i <= $searchParams['children']; $i++)
                                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                        <p class="font-medium text-gray-700 mb-3">Enfant {{ $i }}</p>
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                                <input type="text" name="guests[{{ $searchParams['adults'] + $i - 1 }}][first_name]" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                                <input type="text" name="guests[{{ $searchParams['adults'] + $i - 1 }}][last_name]" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Âge</label>
                                                <input type="number" name="guests[{{ $searchParams['adults'] + $i - 1 }}][age]" min="0" max="17" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                                <input type="text" value="Enfant" readonly
                                                       class="w-full rounded-md border-gray-300 bg-gray-100 cursor-not-allowed">
                                                <input type="hidden" name="guests[{{ $searchParams['adults'] + $i - 1 }}][type]" value="child">
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>

                        <!-- Special Requests -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Demandes spéciales (optionnel)</h3>
                            <textarea name="special_requests" rows="3"
                                      placeholder="Ex: Chambre non-fumeur, lit bébé, étage élevé..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('special_requests') }}</textarea>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" name="terms_accepted" required
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 mt-1">
                                <span class="ml-2 text-sm text-gray-700">
                                    J'accepte les <a href="#" class="text-blue-600 hover:text-blue-700">conditions générales</a> et la
                                    <a href="#" class="text-blue-600 hover:text-blue-700">politique d'annulation</a>
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('hotels.show', $hotel['id']) }}" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium">
                                Annuler
                            </a>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                Procéder au paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Récapitulatif</h3>

                    <div class="space-y-4">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $hotel['name'] }}</p>
                            @if($hotel['stars'])
                                <div class="flex items-center mt-1">
                                    @for($i = 0; $i < $hotel['stars']; $i++)
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endfor
                                </div>
                            @endif
                            <p class="text-sm text-gray-600 mt-1">📍 {{ $hotel['city'] }}, {{ $hotel['country'] }}</p>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Arrivée</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($searchParams['check_in'])->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Départ</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($searchParams['check_out'])->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Durée</span>
                                <span class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($searchParams['check_in'])->diffInDays(\Carbon\Carbon::parse($searchParams['check_out'])) }} nuit(s)
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Voyageurs</span>
                                <span class="font-medium text-gray-900">
                                    {{ $searchParams['adults'] }} adulte(s)
                                    @if(isset($searchParams['children']) && $searchParams['children'] > 0)
                                        , {{ $searchParams['children'] }} enfant(s)
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if(isset($selectedRoom))
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-sm text-gray-600 mb-1">Chambre</p>
                                <p class="font-medium text-gray-900">{{ $selectedRoom['name'] ?? 'Standard' }}</p>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-900 font-semibold">Total</span>
                                <span class="text-2xl font-bold text-blue-600">
                                    {{ number_format($totalPrice ?? 0, 0) }} TND
                                </span>
                            </div>
                            <p class="text-xs text-gray-500">Taxes et frais inclus</p>
                        </div>

                        @auth
                            <div class="bg-green-50 rounded-lg p-3">
                                <p class="text-sm font-medium text-green-900">🌟 Points de fidélité</p>
                                <p class="text-xs text-green-700 mt-1">
                                    Gagnez {{ number_format($totalPrice ?? 0, 0) }} points avec cette réservation
                                </p>
                            </div>
                        @endauth

                        <div class="border-t border-gray-200 pt-4 space-y-2 text-xs text-gray-600">
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Confirmation instantanée</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Paiement sécurisé</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Annulation gratuite</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bookingForm() {
            return {
                init() {
                    // Form validation and interaction logic
                }
            }
        }
    </script>
</x-public-layout>
