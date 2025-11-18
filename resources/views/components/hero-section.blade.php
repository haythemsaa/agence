@props(['variant' => 'primary', 'image' => null, 'overlay' => true])

@php
$variants = [
    'primary' => 'from-blue-600 to-blue-800',
    'success' => 'from-green-500 to-teal-600',
    'adventure' => 'from-orange-500 to-red-600',
    'luxury' => 'from-purple-600 to-pink-600',
    'nature' => 'from-green-600 to-emerald-700',
];

$gradientClass = $variants[$variant] ?? $variants['primary'];
@endphp

<div class="relative bg-gradient-to-r {{ $gradientClass }} overflow-hidden">
    @if($image)
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ $image }}" alt="Hero background" class="w-full h-full object-cover">
            @if($overlay)
                <div class="absolute inset-0 bg-gradient-to-r {{ $gradientClass }} opacity-90"></div>
            @endif
        </div>
    @endif

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        {{ $slot }}
    </div>

    <!-- Decorative Wave -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-12 lg:h-16 text-white fill-current" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</div>
