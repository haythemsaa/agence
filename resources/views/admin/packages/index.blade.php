<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des Voyages Organisés
            </h2>
            <a href="{{ route('admin.packages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                + Nouveau Voyage
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durée</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Places</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($packages as $package)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $package->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($package->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-2 py-1 rounded-full text-xs
                                            @if($package->type === 'omra') bg-purple-100 text-purple-800
                                            @elseif($package->type === 'circuit') bg-blue-100 text-blue-800
                                            @elseif($package->type === 'sejour') bg-green-100 text-green-800
                                            @else bg-orange-100 text-orange-800
                                            @endif">
                                            {{ ucfirst($package->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $package->duration_days }}J / {{ $package->duration_nights }}N
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ number_format($package->price_adult, 2) }} TND
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ $package->max_participants - $package->bookings_sum_nb_adults ?? 0 }} / {{ $package->max_participants }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-2 py-1 rounded-full text-xs {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $package->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm space-x-2">
                                        <a href="{{ route('admin.packages.show', $package) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                                        <a href="{{ route('admin.packages.edit', $package) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Confirmer la suppression ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Aucun voyage organisé pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $packages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
