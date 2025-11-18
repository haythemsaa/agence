@props(['discount', 'endTime' => null])

<div class="relative">
    <!-- Flash Sale Badge -->
    <div class="absolute top-0 left-0 z-10">
        <div class="bg-red-600 text-white px-3 py-1 rounded-br-lg rounded-tl-lg shadow-lg">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                <span class="font-bold text-sm">-{{ $discount }}%</span>
            </div>
        </div>
    </div>

    @if($endTime)
        <div class="absolute top-12 left-0 z-10">
            <x-countdown-timer :endTime="$endTime" size="small" />
        </div>
    @endif
</div>
