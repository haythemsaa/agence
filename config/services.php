<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Hotelbeds API Configuration
    |--------------------------------------------------------------------------
    */
    'hotelbeds' => [
        'api_key' => env('HOTELBEDS_API_KEY'),
        'secret' => env('HOTELBEDS_SECRET'),
        'base_url' => env('HOTELBEDS_BASE_URL', 'https://api.hotelbeds.com'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Payment Configuration
    |--------------------------------------------------------------------------
    */
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | PayPal Payment Configuration
    |--------------------------------------------------------------------------
    */
    'paypal' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'sandbox' => [
            'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
            'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
        ],
        'live' => [
            'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
            'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Flouci Payment Configuration (Tunisie)
    |--------------------------------------------------------------------------
    */
    'flouci' => [
        'app_token' => env('FLOUCI_APP_TOKEN'),
        'app_secret' => env('FLOUCI_APP_SECRET'),
        'base_url' => env('FLOUCI_BASE_URL', 'https://api.flouci.com'),
    ],

    /*
    |--------------------------------------------------------------------------
    | ExchangeRate API Configuration
    |--------------------------------------------------------------------------
    */
    'exchangerate' => [
        'key' => env('EXCHANGERATE_API_KEY', 'demo-key'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tawk.to Live Chat Configuration
    |--------------------------------------------------------------------------
    | Get your property_id and widget_id from: https://dashboard.tawk.to
    | Format: https://embed.tawk.to/{property_id}/{widget_id}
    */
    'tawkto' => [
        'property_id' => env('TAWKTO_PROPERTY_ID'),
        'widget_id' => env('TAWKTO_WIDGET_ID'),
        'api_key' => env('TAWKTO_API_KEY'), // Optional: for secure mode
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business Configuration
    |--------------------------------------------------------------------------
    | Direct contact button with pre-filled messages
    */
    'whatsapp' => [
        'number' => env('WHATSAPP_NUMBER', '21612345678'),
        'default_message' => env('WHATSAPP_DEFAULT_MESSAGE', 'Bonjour, je souhaite des informations sur vos offres de voyage.'),
    ],

];
