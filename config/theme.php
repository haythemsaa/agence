<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Theme Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the travel agency theme colors, fonts, and styles
    |
    */

    'name' => 'Agence Voyage Pro',
    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | Color Palette
    |--------------------------------------------------------------------------
    */
    'colors' => [
        'primary' => [
            'light' => '#3B82F6', // blue-500
            'DEFAULT' => '#2563EB', // blue-600
            'dark' => '#1E40AF', // blue-800
        ],
        'secondary' => [
            'light' => '#10B981', // green-500
            'DEFAULT' => '#059669', // green-600
            'dark' => '#047857', // green-700
        ],
        'accent' => [
            'orange' => '#F97316', // orange-500
            'purple' => '#A855F7', // purple-500
            'pink' => '#EC4899', // pink-500
        ],
        'success' => '#10B981', // green-500
        'warning' => '#F59E0B', // amber-500
        'error' => '#EF4444', // red-500
        'info' => '#3B82F6', // blue-500
    ],

    /*
    |--------------------------------------------------------------------------
    | Typography
    |--------------------------------------------------------------------------
    */
    'typography' => [
        'font_family' => [
            'primary' => 'Figtree, ui-sans-serif, system-ui, sans-serif',
            'headings' => 'Figtree, ui-sans-serif, system-ui, sans-serif',
            'mono' => 'ui-monospace, monospace',
        ],
        'font_sizes' => [
            'xs' => '0.75rem',
            'sm' => '0.875rem',
            'base' => '1rem',
            'lg' => '1.125rem',
            'xl' => '1.25rem',
            '2xl' => '1.5rem',
            '3xl' => '1.875rem',
            '4xl' => '2.25rem',
            '5xl' => '3rem',
            '6xl' => '3.75rem',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout Settings
    |--------------------------------------------------------------------------
    */
    'layout' => [
        'max_width' => '7xl', // max-w-7xl
        'container_padding' => [
            'mobile' => 'px-4',
            'tablet' => 'sm:px-6',
            'desktop' => 'lg:px-8',
        ],
        'section_spacing' => [
            'small' => 'py-8',
            'medium' => 'py-12',
            'large' => 'py-16',
            'xlarge' => 'py-24',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Component Styles
    |--------------------------------------------------------------------------
    */
    'components' => [
        'button' => [
            'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
            'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-900',
            'success' => 'bg-green-600 hover:bg-green-700 text-white',
            'danger' => 'bg-red-600 hover:bg-red-700 text-white',
            'outline' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50',
        ],
        'card' => [
            'default' => 'bg-white rounded-lg shadow-md hover:shadow-xl transition',
            'featured' => 'bg-white rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1',
        ],
        'badge' => [
            'primary' => 'bg-blue-100 text-blue-800',
            'success' => 'bg-green-100 text-green-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            'error' => 'bg-red-100 text-red-800',
            'info' => 'bg-gray-100 text-gray-800',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Hero Variants
    |--------------------------------------------------------------------------
    */
    'hero_variants' => [
        'primary' => 'from-blue-600 to-blue-800',
        'success' => 'from-green-500 to-teal-600',
        'adventure' => 'from-orange-500 to-red-600',
        'luxury' => 'from-purple-600 to-pink-600',
        'nature' => 'from-green-600 to-emerald-700',
    ],

    /*
    |--------------------------------------------------------------------------
    | Package Type Colors
    |--------------------------------------------------------------------------
    */
    'package_types' => [
        'omra' => [
            'gradient' => 'from-green-400 to-green-600',
            'badge' => 'bg-green-100 text-green-800',
        ],
        'circuit' => [
            'gradient' => 'from-orange-400 to-orange-600',
            'badge' => 'bg-orange-100 text-orange-800',
        ],
        'sejour' => [
            'gradient' => 'from-blue-400 to-blue-600',
            'badge' => 'bg-blue-100 text-blue-800',
        ],
        'international' => [
            'gradient' => 'from-purple-400 to-purple-600',
            'badge' => 'bg-purple-100 text-purple-800',
        ],
        'tre' => [
            'gradient' => 'from-teal-400 to-teal-600',
            'badge' => 'bg-teal-100 text-teal-800',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Animation Settings
    |--------------------------------------------------------------------------
    */
    'animations' => [
        'duration' => [
            'fast' => '150ms',
            'normal' => '300ms',
            'slow' => '500ms',
        ],
        'easing' => [
            'default' => 'ease-in-out',
            'smooth' => 'cubic-bezier(0.4, 0, 0.2, 1)',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */
    'features' => [
        'dark_mode' => false, // Not enabled yet
        'rtl_support' => true, // For Arabic language
        'animations_enabled' => true,
        'lazy_loading' => true,
    ],
];
