import './bootstrap';

import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';

window.Alpine = Alpine;
window.flatpickr = flatpickr;

Alpine.start();

// Initialize Flatpickr on date inputs
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all date inputs with class 'datepicker'
    const dateInputs = document.querySelectorAll('input[type="date"], .datepicker');

    dateInputs.forEach(input => {
        // Skip if already initialized
        if (input._flatpickr) return;

        const config = {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd/m/Y',
            minDate: input.getAttribute('min') || 'today',
            maxDate: input.getAttribute('max') || null,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                    longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
                },
                months: {
                    shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                }
            }
        };

        flatpickr(input, config);
    });
});
