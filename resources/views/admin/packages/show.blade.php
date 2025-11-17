<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails du Voyage
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $package->title }}</h3>
                            <p class="text-gray-600 mt-2">{{ $package->destination }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.packages.edit', $package) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Modifier
                            </a>
                            <a href="{{ route('admin.packages.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Retour
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <p class="text-sm text-gray-600">Type</p>
                            <p class="text-lg font-semibold">{{ ucfirst($package->type) }}</p>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <p class="text-sm text-gray-600">Durée</p>
                            <p class="text-lg font-semibold">{{ $package->duration_days }}J / {{ $package->duration_nights }}N</p>
                        </div>
                        <div class="border-l-4 border-purple-500 pl-4">
                            <p class="text-sm text-gray-600">Prix Adulte</p>
                            <p class="text-lg font-semibold">{{ number_format($package->price_adult, 2) }} TND</p>
                        </div>
                        <div class="border-l-4 border-orange-500 pl-4">
                            <p class="text-sm text-gray-600">Participants</p>
                            <p class="text-lg font-semibold">{{ $package->min_participants }} - {{ $package->max_participants }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-semibold text-lg mb-2">Description</h4>
                        <p class="text-gray-700">{{ $package->description }}</p>
                    </div>

                    @if($package->program)
                        <div class="mb-6">
                            <h4 class="font-semibold text-lg mb-2">Programme</h4>
                            <div class="space-y-2">
                                @foreach($package->program as $day => $description)
                                    <div class="border-l-2 border-blue-300 pl-3 py-1">
                                        <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $day)) }}:</span> {{ $description }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        @if($package->included)
                            <div>
                                <h4 class="font-semibold text-lg mb-2 text-green-700">✓ Inclus</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach((is_array($package->included) ? $package->included : explode("\n", $package->included)) as $item)
                                        @if(trim($item))
                                            <li class="text-gray-700">{{ trim($item) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($package->not_included)
                            <div>
                                <h4 class="font-semibold text-lg mb-2 text-red-700">✗ Non Inclus</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach((is_array($package->not_included) ? $package->not_included : explode("\n", $package->not_included)) as $item)
                                        @if(trim($item))
                                            <li class="text-gray-700">{{ trim($item) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    @if($package->available_dates)
                        <div class="mb-6">
                            <h4 class="font-semibold text-lg mb-2">Dates de Départ</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach((is_array($package->available_dates) ? $package->available_dates : explode("\n", $package->available_dates)) as $date)
                                    @if(trim($date))
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ trim($date) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 pt-6 border-t">
                        <p class="text-sm text-gray-600">
                            Statut: <span class="font-semibold {{ $package->is_active ? 'text-green-600' : 'text-red-600' }}">{{ $package->is_active ? 'Actif' : 'Inactif' }}</span>
                        </p>
                        <p class="text-sm text-gray-600 mt-1">Créé le: {{ $package->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
