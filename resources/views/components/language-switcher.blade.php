@php
    $currentLocale = app()->getLocale();
    $languages = [
        'fr' => ['name' => 'Français', 'flag' => '🇫🇷'],
        'en' => ['name' => 'English', 'flag' => '🇬🇧'],
        'ar' => ['name' => 'العربية', 'flag' => '🇸🇦'],
    ];
@endphp

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
        <span class="mr-2">{{ $languages[$currentLocale]['flag'] }}</span>
        <span class="hidden sm:inline">{{ strtoupper($currentLocale) }}</span>
        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
         style="display: none;">
        <div class="py-1" role="menu">
            @foreach($languages as $code => $language)
                <a href="?lang={{ $code }}"
                   class="block px-4 py-2 text-sm {{ $currentLocale === $code ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} flex items-center justify-between {{ $code === 'ar' ? 'flex-row-reverse' : '' }}"
                   role="menuitem">
                    <span class="flex items-center {{ $code === 'ar' ? 'flex-row-reverse' : '' }}">
                        <span class="{{ $code === 'ar' ? 'ml-3' : 'mr-3' }} text-xl">{{ $language['flag'] }}</span>
                        <span>{{ $language['name'] }}</span>
                    </span>
                    @if($currentLocale === $code)
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
