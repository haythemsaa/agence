@props(['type' => 'hotels'])

<div x-data="{
    searchType: '{{ $type }}',
    showAdvanced: false,
    budget: { min: 0, max: 5000 },
    rating: 0
}" class="bg-white rounded-xl shadow-2xl p-6 lg:p-8">

    <!-- Search Type Tabs -->
    <div class="flex flex-wrap border-b border-gray-200 mb-6 gap-2">
        <button @click="searchType = 'hotels'"
                :class="searchType === 'hotels' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-3 px-6 border-b-2 font-medium text-sm focus:outline-none transition rounded-t-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Hôtels
            </div>
        </button>
        <button @click="searchType = 'packages'"
                :class="searchType === 'packages' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-3 px-6 border-b-2 font-medium text-sm focus:outline-none transition rounded-t-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Voyages Organisés
            </div>
        </button>
        <button @click="searchType = 'omra'"
                :class="searchType === 'omra' ? 'border-green-600 text-green-600 bg-green-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-3 px-6 border-b-2 font-medium text-sm focus:outline-none transition rounded-t-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
                Omra
            </div>
        </button>
    </div>

    <!-- Hotel Search -->
    <form x-show="searchType === 'hotels'" x-cloak action="{{ route('hotels.search') }}" method="GET" class="space-y-6">
        <!-- Basic Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                <select name="destination" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Choisir une destination</option>
                    <option value="HAM">Hammamet</option>
                    <option value="SOU">Sousse</option>
                    <option value="DJE">Djerba</option>
                    <option value="TUN">Tunis</option>
                    <option value="MAH">Mahdia</option>
                    <option value="MON">Monastir</option>
                    <option value="TOZ">Tozeur</option>
                    <option value="TAB">Tabarka</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Arrivée</label>
                <input type="date" name="check_in" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Départ</label>
                <input type="date" name="check_out" required min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Adultes</label>
                <input type="number" name="adults" min="1" max="9" value="2" required
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Enfants</label>
                <input type="number" name="children" min="0" max="9" value="0"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Chambres</label>
                <input type="number" name="rooms" min="1" max="9" value="1"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <!-- Advanced Filters Toggle -->
        <div class="border-t border-gray-200 pt-4">
            <button type="button" @click="showAdvanced = !showAdvanced"
                    class="flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                <svg class="w-5 h-5 mr-2 transition-transform" :class="{ 'rotate-180': showAdvanced }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <span x-text="showAdvanced ? 'Masquer les filtres avancés' : 'Afficher les filtres avancés'"></span>
            </button>
        </div>

        <!-- Advanced Filters -->
        <div x-show="showAdvanced" x-collapse class="space-y-4 bg-gray-50 rounded-lg p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Budget Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Budget (TND): <span x-text="budget.min + ' - ' + budget.max"></span>
                    </label>
                    <div class="flex gap-4">
                        <input type="range" x-model="budget.min" min="0" max="5000" step="100"
                               name="min_price" class="w-full">
                        <input type="range" x-model="budget.max" min="0" max="5000" step="100"
                               name="max_price" class="w-full">
                    </div>
                </div>

                <!-- Star Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Étoiles minimum</label>
                    <select name="min_stars" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Toutes</option>
                        <option value="3">3 étoiles et plus</option>
                        <option value="4">4 étoiles et plus</option>
                        <option value="5">5 étoiles uniquement</option>
                    </select>
                </div>
            </div>

            <!-- Amenities -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Équipements</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="wifi" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">WiFi</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="pool" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Piscine</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="spa" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Spa</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="parking" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Parking</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-8 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition transform hover:scale-105 shadow-lg">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Rechercher des hôtels
            </div>
        </button>
    </form>

    <!-- Package Search -->
    <form x-show="searchType === 'packages' || searchType === 'omra'" x-cloak action="{{ route('packages.index') }}" method="GET" class="space-y-6">
        <input type="hidden" name="type" :value="searchType === 'omra' ? 'omra' : ''">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type de voyage</label>
                <select name="package_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tous les types</option>
                    <option value="circuit">Circuits</option>
                    <option value="sejour">Séjours</option>
                    <option value="omra">Omra</option>
                    <option value="international">International</option>
                    <option value="tre">TRE (Tunisiens à l'étranger)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                <input type="text" name="destination" placeholder="Ex: Djerba, Istanbul, Paris..."
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de départ</label>
                <input type="date" name="departure_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Durée</label>
                <select name="duration" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Toutes durées</option>
                    <option value="3-5">3-5 jours</option>
                    <option value="6-9">6-9 jours</option>
                    <option value="10-14">10-14 jours</option>
                    <option value="15+">15 jours et plus</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-8 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition transform hover:scale-105 shadow-lg">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span x-text="searchType === 'omra' ? 'Rechercher des Omra' : 'Rechercher des voyages'"></span>
            </div>
        </button>
    </form>
</div>
