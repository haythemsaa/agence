<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier l'Utilisateur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Points de Fidélité</label>
                                <input type="number" name="loyalty_points" value="{{ old('loyalty_points', $user->loyalty_points) }}" min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Niveau de Fidélité</label>
                                <select name="loyalty_level"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="bronze" {{ old('loyalty_level', $user->loyalty_level) === 'bronze' ? 'selected' : '' }}>Bronze</option>
                                    <option value="silver" {{ old('loyalty_level', $user->loyalty_level) === 'silver' ? 'selected' : '' }}>Silver</option>
                                    <option value="gold" {{ old('loyalty_level', $user->loyalty_level) === 'gold' ? 'selected' : '' }}>Gold</option>
                                    <option value="platinum" {{ old('loyalty_level', $user->loyalty_level) === 'platinum' ? 'selected' : '' }}>Platinum</option>
                                </select>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Administrateur</span>
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nouveau Mot de Passe (laisser vide pour ne pas changer)</label>
                                <input type="password" name="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.users.index') }}"
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
