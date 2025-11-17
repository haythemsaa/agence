@props(['emissions'])

@php
    $service = app(\App\Services\CarbonFootprintService::class);
    $rating = $emissions < 100 ? ['grade' => 'A', 'color' => 'green'] :
             ($emissions < 300 ? ['grade' => 'B', 'color' => 'lime'] :
             ($emissions < 600 ? ['grade' => 'C', 'color' => 'yellow'] :
             ($emissions < 1000 ? ['grade' => 'D', 'color' => 'orange'] :
             ['grade' => 'E', 'color' => 'red'])));

    $colorClasses = [
        'green' => 'bg-green-100 text-green-800 border-green-300',
        'lime' => 'bg-lime-100 text-lime-800 border-lime-300',
        'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
        'orange' => 'bg-orange-100 text-orange-800 border-orange-300',
        'red' => 'bg-red-100 text-red-800 border-red-300',
    ];
@endphp

<div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $colorClasses[$rating['color']] }}" title="Empreinte carbone: {{ $emissions }} kg CO2">
    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"/>
    </svg>
    Éco {{ $rating['grade'] }}
</div>
