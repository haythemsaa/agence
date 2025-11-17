<x-public-layout>
    <x-slot name="title">Réservation - {{ $package->title }}</x-slot>

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
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Réservation du voyage</h2>

                    <form action="{{ route('packages.book', $package->slug) }}" method="POST" x-data="packageBookingForm()">
                        @csrf

                        <!-- Departure Date Selection -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Date de départ</h3>
                            <select name="departure_date" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    x-model="selectedDate">
                                <option value="">Choisir une date de départ</option>
                                @foreach($package->departure_dates as $date)
                                    @php
                                        $availablePlaces = $package->getAvailablePlaces($date);
                                    @endphp
                                    <option value="{{ $date }}"
                                            {{ request('date') == $date ? 'selected' : '' }}
                                            {{ $availablePlaces <= 0 ? 'disabled' : '' }}>
                                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                        ({{ $availablePlaces }} places disponibles)
                                    </option>
                                @endforeach
                            </select>
                            @error('departure_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Participants -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Nombre de participants</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="nb_adults" class="block text-sm font-medium text-gray-700 mb-1">
                                        Adultes <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="nb_adults" id="nb_adults" min="1" max="{{ $package->max_participants }}" value="2" required
                                           x-model.number="nbAdults"
                                           @change="calculateTotal()"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="nb_children" class="block text-sm font-medium text-gray-700 mb-1">
                                        Enfants
                                    </label>
                                    <input type="number" name="nb_children" id="nb_children" min="0" max="9" value="0"
                                           x-model.number="nbChildren"
                                           @change="calculateTotal()"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Groupe limité à {{ $package->max_participants }} participants. Minimum {{ $package->min_participants }} personnes.
                            </p>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de contact</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nom complet <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="contact_name" id="contact_name" required
                                           value="{{ auth()->user()->name ?? old('contact_name') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="contact_email" id="contact_email" required
                                           value="{{ auth()->user()->email ?? old('contact_email') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Téléphone <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="contact_phone" id="contact_phone" required
                                           value="{{ auth()->user()->phone ?? old('contact_phone') }}"
                                           placeholder="+216 XX XXX XXX"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="contact_city" class="block text-sm font-medium text-gray-700 mb-1">
                                        Ville <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="contact_city" id="contact_city" required
                                           value="{{ auth()->user()->city ?? old('contact_city') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Participant Details -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails des participants</h3>
                            <div class="space-y-4">
                                <template x-for="i in nbAdults" :key="'adult-'+i">
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <p class="font-medium text-gray-700 mb-3" x-text="'Adulte ' + i"></p>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                                <input type="text" :name="'participants['+i+'][first_name]'" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                                <input type="text" :name="'participants['+i+'][last_name]'" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                                <input type="text" value="Adulte" readonly
                                                       class="w-full rounded-md border-gray-300 bg-gray-100">
                                                <input type="hidden" :name="'participants['+i+'][type]'" value="adult">
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template x-for="i in nbChildren" :key="'child-'+i">
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <p class="font-medium text-gray-700 mb-3" x-text="'Enfant ' + i"></p>
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                                <input type="text" :name="'participants['+(nbAdults+i)+'][first_name]'" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                                <input type="text" :name="'participants['+(nbAdults+i)+'][last_name]'" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Âge</label>
                                                <input type="number" :name="'participants['+(nbAdults+i)+'][age]'" min="0" max="17" required
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                                <input type="text" value="Enfant" readonly
                                                       class="w-full rounded-md border-gray-300 bg-gray-100">
                                                <input type="hidden" :name="'participants['+(nbAdults+i)+'][type]'" value="child">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Single Supplement -->
                        @if($package->single_supplement)
                            <div class="mb-8">
                                <label class="flex items-start">
                                    <input type="checkbox" name="single_supplement" value="1"
                                           x-model="singleSupplement"
                                           @change="calculateTotal()"
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 mt-1">
                                    <span class="ml-2 text-sm text-gray-700">
                                        Je souhaite une chambre individuelle
                                        <span class="font-semibold">(+{{ number_format($package->single_supplement, 0) }} {{ $package->currency }})</span>
                                    </span>
                                </label>
                            </div>
                        @endif

                        <!-- Payment Plan -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Mode de paiement</h3>
                            <div class="space-y-3">
                                <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="payment_plan" value="full" checked
                                           class="mt-1 border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-3">
                                        <span class="block font-medium text-gray-900">Paiement intégral</span>
                                        <span class="block text-sm text-gray-600">Payez le montant total maintenant</span>
                                    </span>
                                </label>
                                <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="payment_plan" value="installment"
                                           class="mt-1 border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-3">
                                        <span class="block font-medium text-gray-900">Paiement en plusieurs fois</span>
                                        <span class="block text-sm text-gray-600">30% maintenant, le reste avant le départ</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Demandes spéciales (optionnel)</h3>
                            <textarea name="special_requests" rows="3"
                                      placeholder="Régime alimentaire spécial, besoins d'accessibilité, préférences de chambre..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('special_requests') }}</textarea>
                        </div>

                        <!-- Terms -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" name="terms_accepted" required
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 mt-1">
                                <span class="ml-2 text-sm text-gray-700">
                                    J'accepte les <a href="#" class="text-blue-600 hover:text-blue-700">conditions générales de vente</a> et la
                                    <a href="#" class="text-blue-600 hover:text-blue-700">politique d'annulation</a>
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('packages.show', $package->slug) }}" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium">
                                Annuler
                            </a>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                Procéder au paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4" x-data="packageBookingForm()">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Récapitulatif</h3>

                    <div class="space-y-4">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $package->title }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $package->duration_days }}j / {{ $package->duration_nights }}n</p>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Adultes:</span>
                                    <span class="font-medium" x-text="nbAdults"></span>
                                </div>
                                <div class="flex justify-between" x-show="nbChildren > 0">
                                    <span class="text-gray-600">Enfants:</span>
                                    <span class="font-medium" x-text="nbChildren"></span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Adultes (<span x-text="nbAdults"></span>)</span>
                                <span class="font-medium">
                                    <span x-text="(nbAdults * {{ $package->price_adult }}).toFixed(0)"></span> {{ $package->currency }}
                                </span>
                            </div>
                            <div class="flex justify-between" x-show="nbChildren > 0">
                                <span class="text-gray-600">Enfants (<span x-text="nbChildren"></span>)</span>
                                <span class="font-medium">
                                    <span x-text="(nbChildren * {{ $package->price_child ?? 0 }}).toFixed(0)"></span> {{ $package->currency }}
                                </span>
                            </div>
                            @if($package->single_supplement)
                                <div class="flex justify-between" x-show="singleSupplement">
                                    <span class="text-gray-600">Supplément chambre</span>
                                    <span class="font-medium">{{ number_format($package->single_supplement, 0) }} {{ $package->currency }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-blue-600">
                                    <span x-text="totalPrice.toFixed(0)"></span> {{ $package->currency }}
                                </span>
                            </div>
                        </div>

                        @auth
                            <div class="bg-green-50 rounded-lg p-3">
                                <p class="text-sm font-medium text-green-900">🌟 Points de fidélité</p>
                                <p class="text-xs text-green-700 mt-1">
                                    Gagnez <span x-text="totalPrice.toFixed(0)"></span> points avec cette réservation
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
                                <span>Places garanties</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Paiement sécurisé</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function packageBookingForm() {
            return {
                nbAdults: 2,
                nbChildren: 0,
                singleSupplement: false,
                selectedDate: '{{ request("date") }}',
                totalPrice: {{ $package->price_adult * 2 }},

                calculateTotal() {
                    let total = this.nbAdults * {{ $package->price_adult }};
                    if (this.nbChildren > 0) {
                        total += this.nbChildren * {{ $package->price_child ?? 0 }};
                    }
                    if (this.singleSupplement) {
                        total += {{ $package->single_supplement ?? 0 }};
                    }
                    this.totalPrice = total;
                }
            }
        }
    </script>
</x-public-layout>
