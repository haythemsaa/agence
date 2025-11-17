@php
    $currencyService = app(\App\Services\CurrencyService::class);
    $currencies = $currencyService->getSupportedCurrencies();
    $currentCurrency = $currencyService->getUserCurrency();
@endphp

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
        <span class="mr-2">{{ $currencies[$currentCurrency]['flag'] }}</span>
        <span class="hidden sm:inline">{{ $currentCurrency }}</span>
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
         class="absolute right-0 z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
         style="display: none;">
        <div class="py-1" role="menu">
            @foreach($currencies as $code => $currency)
                <button onclick="changeCurrency('{{ $code }}')"
                        class="w-full text-left px-4 py-2 text-sm {{ $currentCurrency === $code ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} flex items-center justify-between"
                        role="menuitem">
                    <span class="flex items-center">
                        <span class="mr-3 text-xl">{{ $currency['flag'] }}</span>
                        <span>{{ $currency['name'] }}</span>
                    </span>
                    <span class="font-semibold">{{ $code }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>

<script>
function changeCurrency(currency) {
    fetch('{{ route("currency.switch") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ currency: currency })
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
