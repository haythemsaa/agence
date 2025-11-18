@props([
    'icon' => 'bi-star-fill',
    'count' => 0,
    'label' => '',
    'suffix' => '',
    'prefix' => '',
    'color' => 'primary',
    'duration' => 2000
])

<div {{ $attributes->merge(['class' => 'd-flex flex-column align-items-center']) }}>
    <div class="mb-3">
        <div class="bg-{{ $color }} bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
            <i class="bi {{ $icon }} text-{{ $color }}" style="font-size: 2.5rem;"></i>
        </div>
    </div>
    <h2 class="mb-1 fw-bold">
        <span class="counter"
              data-target="{{ $count }}"
              data-prefix="{{ $prefix }}"
              data-suffix="{{ $suffix }}"
              data-duration="{{ $duration }}">0</span>
    </h2>
    <p class="text-muted mb-0">{{ $label }}</p>
</div>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');

        const animateCounter = (counter) => {
            const target = parseInt(counter.dataset.target);
            const duration = parseInt(counter.dataset.duration);
            const prefix = counter.dataset.prefix || '';
            const suffix = counter.dataset.suffix || '';
            const start = 0;
            const increment = target / (duration / 16); // 60 FPS

            let current = start;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = prefix + target.toLocaleString() + suffix;
                }
            };

            updateCounter();
        };

        // Intersection Observer to trigger animation when visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    entry.target.classList.add('animated');
                    animateCounter(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            observer.observe(counter);
        });
    });
</script>
@endpush
@endonce
