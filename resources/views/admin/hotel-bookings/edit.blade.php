<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier Réservation #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.hotel-bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut</label>
                                <select name="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Terminé</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prix Total (TND)</label>
                                <input type="number" name="total_price" value="{{ $booking->total_price }}" step="0.01" min="0" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes (usage interne)</label>
                                <textarea name="notes" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $booking->notes ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.hotel-bookings.index') }}"
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
