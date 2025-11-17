<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💝 Mes Favoris
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($wishlists->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($wishlists as $wishlist)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if($wishlist->wishlistable_type === 'App\Models\Hotel')
                                {{-- Hotel Card --}}
                                <div class="relative">
                                    @if($wishlist->wishlistable->images && count($wishlist->wishlistable->images) > 0)
                                        <img src="{{ $wishlist->wishlistable->images[0] }}" alt="{{ $wishlist->wishlistable->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                            <span class="text-white text-6xl">🏨</span>
                                        </div>
                                    @endif
                                    <button onclick="removeFromWishlist({{ $wishlist->id }})" class="absolute top-2 right-2 bg-white rounded-full p-2 shadow hover:bg-red-50">
                                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $wishlist->wishlistable->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">📍 {{ $wishlist->wishlistable->city }}, {{ $wishlist->wishlistable->country }}</p>
                                    @if($wishlist->wishlistable->rating)
                                        <div class="flex items-center mb-2">
                                            <span class="text-yellow-400">⭐</span>
                                            <span class="text-sm ml-1">{{ $wishlist->wishlistable->rating }}/5</span>
                                        </div>
                                    @endif
                                    <a href="{{ route('hotels.show', $wishlist->wishlistable->id) }}" class="mt-4 block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                                        Voir les détails
                                    </a>
                                </div>
                            @else
                                {{-- Package Card --}}
                                <div class="relative">
                                    @if($wishlist->wishlistable->images && count($wishlist->wishlistable->images) > 0)
                                        <img src="{{ $wishlist->wishlistable->images[0] }}" alt="{{ $wishlist->wishlistable->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                                            <span class="text-white text-6xl">✈️</span>
                                        </div>
                                    @endif
                                    <button onclick="removeFromWishlist({{ $wishlist->id }})" class="absolute top-2 right-2 bg-white rounded-full p-2 shadow hover:bg-red-50">
                                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <span class="absolute top-2 left-2 bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ ucfirst($wishlist->wishlistable->type) }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $wishlist->wishlistable->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">📍 {{ $wishlist->wishlistable->destination }}</p>
                                    <p class="text-gray-600 text-sm mb-2">⏱️ {{ $wishlist->wishlistable->duration_days }}J / {{ $wishlist->wishlistable->duration_nights }}N</p>
                                    <p class="text-blue-600 font-bold text-lg mb-4">{{ number_format($wishlist->wishlistable->price_adult, 2) }} TND</p>
                                    <a href="{{ route('packages.show', $wishlist->wishlistable->slug) }}" class="block w-full text-center bg-green-600 text-white py-2 rounded hover:bg-green-700">
                                        Voir les détails
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">💔</div>
                    <h3 class="text-2xl font-bold mb-2">Votre liste de favoris est vide</h3>
                    <p class="text-gray-600 mb-6">Parcourez nos hôtels et voyages organisés et cliquez sur le cœur pour les ajouter ici</p>
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('hotels.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                            Découvrir les hôtels
                        </a>
                        <a href="{{ route('packages.index') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                            Découvrir les voyages
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function removeFromWishlist(wishlistId) {
            if (!confirm('Retirer cet article de vos favoris ?')) return;

            fetch(`/wishlist/${wishlistId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</x-app-layout>
