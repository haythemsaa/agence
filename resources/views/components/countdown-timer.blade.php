@props(['endTime', 'size' => 'normal'])

@php
    $sizeClasses = $size === 'small' ? 'text-xs' : 'text-sm';
    $timerClasses = $size === 'small' ? 'text-lg font-bold' : 'text-2xl font-bold';
@endphp

<div
    x-data="countdownTimer('{{ $endTime }}')"
    x-init="startTimer()"
    class="inline-flex items-center gap-2 {{ $sizeClasses }}"
>
    <template x-if="!expired">
        <div class="flex items-center gap-2 bg-red-100 text-red-800 px-3 py-2 rounded-lg">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <div class="flex items-center gap-1">
                <template x-if="days > 0">
                    <span>
                        <span class="{{ $timerClasses }}" x-text="days"></span>
                        <span class="text-xs">j</span>
                    </span>
                </template>
                <span>
                    <span class="{{ $timerClasses }}" x-text="hours.toString().padStart(2, '0')"></span>
                    <span class="text-xs">h</span>
                </span>
                <span>:</span>
                <span>
                    <span class="{{ $timerClasses }}" x-text="minutes.toString().padStart(2, '0')"></span>
                    <span class="text-xs">m</span>
                </span>
                <span>:</span>
                <span>
                    <span class="{{ $timerClasses }}" x-text="seconds.toString().padStart(2, '0')"></span>
                    <span class="text-xs">s</span>
                </span>
            </div>
        </div>
    </template>

    <template x-if="expired">
        <div class="bg-gray-200 text-gray-600 px-3 py-2 rounded-lg">
            <span class="text-sm font-semibold">Vente flash terminée</span>
        </div>
    </template>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('countdownTimer', (endTime) => ({
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
            expired: false,
            interval: null,

            startTimer() {
                this.updateTimer();
                this.interval = setInterval(() => {
                    this.updateTimer();
                }, 1000);
            },

            updateTimer() {
                const end = new Date(endTime).getTime();
                const now = new Date().getTime();
                const distance = end - now;

                if (distance < 0) {
                    this.expired = true;
                    if (this.interval) {
                        clearInterval(this.interval);
                    }
                    return;
                }

                this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
            }
        }));
    });
</script>
