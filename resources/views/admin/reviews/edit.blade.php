<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modérer l'Avis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">Client</p>
                        <p class="font-semibold">{{ $review->user->name }} ({{ $review->user->email }})</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-600">Note</p>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-2xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                            <span class="ml-2 text-lg">({{ $review->rating }}/5)</span>
                        </div>
                    </div>

                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                                <textarea name="comment" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('comment', $review->comment) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Réponse de l'agence (optionnel)</label>
                                <textarea name="admin_response" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('admin_response', $review->admin_response) }}</textarea>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $review->is_published) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Publier cet avis</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.reviews.index') }}"
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
