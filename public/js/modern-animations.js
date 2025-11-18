/**
 * Modern Animations & Interactions
 * VoyageLuxe - Agence de Voyage Tunisie
 */

// Smooth Page Transitions
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in animation to body
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease-in';

    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

// Enhanced Parallax Effect
class ParallaxEffect {
    constructor() {
        this.parallaxElements = document.querySelectorAll('[data-parallax]');
        this.init();
    }

    init() {
        if (this.parallaxElements.length === 0) return;

        window.addEventListener('scroll', () => this.handleScroll(), { passive: true });
        this.handleScroll(); // Initial call
    }

    handleScroll() {
        const scrollTop = window.pageYOffset;

        this.parallaxElements.forEach(element => {
            const speed = parseFloat(element.dataset.parallax) || 0.5;
            const yPos = -(scrollTop * speed);
            element.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    }
}

// Scroll Reveal Animation
class ScrollReveal {
    constructor() {
        this.elements = document.querySelectorAll('[data-scroll-reveal]');
        this.init();
    }

    init() {
        if (this.elements.length === 0) return;

        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        this.elements.forEach(element => {
            element.classList.add('scroll-reveal');
            observer.observe(element);
        });
    }
}

// Magnetic Buttons Effect
class MagneticButton {
    constructor() {
        this.buttons = document.querySelectorAll('.btn-magnetic');
        this.init();
    }

    init() {
        this.buttons.forEach(button => {
            button.addEventListener('mousemove', (e) => this.handleMove(e, button));
            button.addEventListener('mouseleave', () => this.handleLeave(button));
        });
    }

    handleMove(e, button) {
        const rect = button.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;

        button.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
    }

    handleLeave(button) {
        button.style.transform = 'translate(0, 0)';
    }
}

// Smooth Scroll with Easing
class SmoothScroll {
    constructor() {
        this.links = document.querySelectorAll('a[href^="#"]');
        this.init();
    }

    init() {
        this.links.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href === '#' || !document.querySelector(href)) return;

                e.preventDefault();
                this.scrollTo(href);
            });
        });
    }

    scrollTo(target) {
        const element = document.querySelector(target);
        if (!element) return;

        const targetPosition = element.getBoundingClientRect().top + window.pageYOffset - 100;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        const duration = 1000;
        let start = null;

        const easeInOutCubic = (t) => {
            return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
        };

        const animation = (currentTime) => {
            if (start === null) start = currentTime;
            const timeElapsed = currentTime - start;
            const progress = Math.min(timeElapsed / duration, 1);
            const ease = easeInOutCubic(progress);

            window.scrollTo(0, startPosition + (distance * ease));

            if (timeElapsed < duration) {
                requestAnimationFrame(animation);
            }
        };

        requestAnimationFrame(animation);
    }
}

// Card Hover Effects
class CardEffects {
    constructor() {
        this.cards = document.querySelectorAll('.card-elegant, .card-hover-effect');
        this.init();
    }

    init() {
        this.cards.forEach(card => {
            card.addEventListener('mouseenter', () => this.handleEnter(card));
            card.addEventListener('mousemove', (e) => this.handleMove(e, card));
            card.addEventListener('mouseleave', () => this.handleLeave(card));
        });
    }

    handleEnter(card) {
        card.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    }

    handleMove(e, card) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 20;
        const rotateY = (centerX - x) / 20;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
    }

    handleLeave(card) {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
    }
}

// Typing Effect
class TypingEffect {
    constructor(element, texts, speed = 100, deleteSpeed = 50, pauseTime = 2000) {
        this.element = element;
        this.texts = texts;
        this.speed = speed;
        this.deleteSpeed = deleteSpeed;
        this.pauseTime = pauseTime;
        this.textIndex = 0;
        this.charIndex = 0;
        this.isDeleting = false;
        this.init();
    }

    init() {
        if (!this.element || this.texts.length === 0) return;
        this.type();
    }

    type() {
        const currentText = this.texts[this.textIndex];

        if (this.isDeleting) {
            this.element.textContent = currentText.substring(0, this.charIndex - 1);
            this.charIndex--;
        } else {
            this.element.textContent = currentText.substring(0, this.charIndex + 1);
            this.charIndex++;
        }

        let typeSpeed = this.isDeleting ? this.deleteSpeed : this.speed;

        if (!this.isDeleting && this.charIndex === currentText.length) {
            typeSpeed = this.pauseTime;
            this.isDeleting = true;
        } else if (this.isDeleting && this.charIndex === 0) {
            this.isDeleting = false;
            this.textIndex = (this.textIndex + 1) % this.texts.length;
            typeSpeed = 500;
        }

        setTimeout(() => this.type(), typeSpeed);
    }
}

// Loading Progress Bar
class LoadingProgress {
    constructor() {
        this.createProgressBar();
        this.init();
    }

    createProgressBar() {
        const bar = document.createElement('div');
        bar.id = 'loading-progress';
        bar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            z-index: 999999;
            transition: width 0.3s ease;
        `;
        document.body.appendChild(bar);
        this.bar = bar;
    }

    init() {
        // Simulate loading progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 30;
            if (progress > 90) progress = 90;
            this.bar.style.width = progress + '%';
        }, 100);

        window.addEventListener('load', () => {
            clearInterval(interval);
            this.bar.style.width = '100%';
            setTimeout(() => {
                this.bar.style.opacity = '0';
                setTimeout(() => this.bar.remove(), 300);
            }, 200);
        });
    }
}

// Image Lazy Loading with Blur Effect
class LazyImageLoader {
    constructor() {
        this.images = document.querySelectorAll('img[data-src]');
        this.init();
    }

    init() {
        if (this.images.length === 0) return;

        const observerOptions = {
            threshold: 0,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadImage(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        this.images.forEach(img => {
            img.style.filter = 'blur(10px)';
            img.style.transition = 'filter 0.3s ease';
            observer.observe(img);
        });
    }

    loadImage(img) {
        const src = img.dataset.src;
        if (!src) return;

        const tempImg = new Image();
        tempImg.onload = () => {
            img.src = src;
            img.style.filter = 'blur(0)';
            img.removeAttribute('data-src');
        };
        tempImg.src = src;
    }
}

// Initialize all effects
document.addEventListener('DOMContentLoaded', function() {
    new ParallaxEffect();
    new ScrollReveal();
    new MagneticButton();
    new SmoothScroll();
    new CardEffects();
    new LazyImageLoader();
    new LoadingProgress();

    // Initialize typing effect if element exists
    const typingElement = document.querySelector('.typing-effect');
    if (typingElement && typingElement.dataset.texts) {
        const texts = JSON.parse(typingElement.dataset.texts);
        new TypingEffect(typingElement, texts);
    }
});

// Add CSS for scroll reveal
const style = document.createElement('style');
style.textContent = `
    .scroll-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }

    .btn-magnetic {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
`;
document.head.appendChild(style);

// Export for use in other scripts
window.ModernAnimations = {
    ParallaxEffect,
    ScrollReveal,
    MagneticButton,
    SmoothScroll,
    CardEffects,
    TypingEffect,
    LazyImageLoader
};
