<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le Voyage: {{ $package->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Titre -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Titre *</label>
                                <input type="text" name="title" value="{{ old('title', $package->title) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type *</label>
                                <select name="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="circuit" {{ old('type', $package->type) === 'circuit' ? 'selected' : '' }}>Circuit</option>
                                    <option value="sejour" {{ old('type', $package->type) === 'sejour' ? 'selected' : '' }}>Séjour</option>
                                    <option value="omra" {{ old('type', $package->type) === 'omra' ? 'selected' : '' }}>Omra</option>
                                    <option value="international" {{ old('type', $package->type) === 'international' ? 'selected' : '' }}>International</option>
                                </select>
                            </div>

                            <!-- Destination -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Destination *</label>
                                <input type="text" name="destination" value="{{ old('destination', $package->destination) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Durée -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jours *</label>
                                <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" required min="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nuits *</label>
                                <input type="number" name="duration_nights" value="{{ old('duration_nights', $package->duration_nights) }}" required min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Prix -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prix Adulte (TND) *</label>
                                <input type="number" name="price_adult" value="{{ old('price_adult', $package->price_adult) }}" required min="0" step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prix Enfant (TND)</label>
                                <input type="number" name="price_child" value="{{ old('price_child', $package->price_child) }}" min="0" step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Participants -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Min Participants</label>
                                <input type="number" name="min_participants" value="{{ old('min_participants', $package->min_participants) }}" min="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Max Participants *</label>
                                <input type="number" name="max_participants" value="{{ old('max_participants', $package->max_participants) }}" required min="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Ville de départ -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Ville de Départ *</label>
                                <input type="text" name="departure_city" value="{{ old('departure_city', $package->departure_city) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Description -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea name="description" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $package->description) }}</textarea>
                            </div>

                            <!-- Programme -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Programme (JSON)</label>
                                <textarea name="program" rows="6"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm">{{ old('program', json_encode($package->program, JSON_PRETTY_PRINT)) }}</textarea>
                            </div>

                            <!-- Inclus/Non inclus -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Inclus (un par ligne)</label>
                                <textarea name="included" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('included', is_array($package->included) ? implode("\n", $package->included) : $package->included) }}</textarea>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Non Inclus (un par ligne)</label>
                                <textarea name="not_included" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('not_included', is_array($package->not_included) ? implode("\n", $package->not_included) : $package->not_included) }}</textarea>
                            </div>

                            <!-- Dates de départ -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Dates de Départ (une par ligne)</label>
                                <textarea name="available_dates" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('available_dates', is_array($package->available_dates) ? implode("\n", $package->available_dates) : $package->available_dates) }}</textarea>
                            </div>

                            <!-- Images -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Images (URLs, une par ligne)</label>
                                <textarea name="images" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('images', is_array($package->images) ? implode("\n", $package->images) : $package->images) }}</textarea>
                            </div>

                            <!-- Actif -->
                            <div class="col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Voyage actif</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.packages.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
