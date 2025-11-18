<div class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Happy Clients -->
            <div class="text-center text-white">
                <div class="mb-3">
                    <svg class="w-12 h-12 mx-auto text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div x-data="{ count: 0 }"
                     x-init="$nextTick(() => { let interval = setInterval(() => { if(count < 50000) count += 500; else clearInterval(interval); }, 20); })"
                     class="text-4xl lg:text-5xl font-bold mb-2">
                    <span x-text="count.toLocaleString()">0</span>+
                </div>
                <p class="text-blue-100 text-sm lg:text-base">Clients Satisfaits</p>
            </div>

            <!-- Years of Experience -->
            <div class="text-center text-white">
                <div class="mb-3">
                    <svg class="w-12 h-12 mx-auto text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div x-data="{ count: 0 }"
                     x-init="$nextTick(() => { let interval = setInterval(() => { if(count < 15) count++; else clearInterval(interval); }, 100); })"
                     class="text-4xl lg:text-5xl font-bold mb-2">
                    <span x-text="count">0</span>+
                </div>
                <p class="text-blue-100 text-sm lg:text-base">Années d'Expérience</p>
            </div>

            <!-- Destinations -->
            <div class="text-center text-white">
                <div class="mb-3">
                    <svg class="w-12 h-12 mx-auto text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div x-data="{ count: 0 }"
                     x-init="$nextTick(() => { let interval = setInterval(() => { if(count < 120) count += 2; else clearInterval(interval); }, 30); })"
                     class="text-4xl lg:text-5xl font-bold mb-2">
                    <span x-text="count">0</span>+
                </div>
                <p class="text-blue-100 text-sm lg:text-base">Destinations</p>
            </div>

            <!-- Success Rate -->
            <div class="text-center text-white">
                <div class="mb-3">
                    <svg class="w-12 h-12 mx-auto text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <div class="text-4xl lg:text-5xl font-bold mb-2">
                    4.9
                </div>
                <p class="text-blue-100 text-sm lg:text-base">Note Moyenne</p>
            </div>
        </div>
    </div>
</div>
