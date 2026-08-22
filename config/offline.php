<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Offline Mode Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration determines whether the application should use
    | offline assets (local files) or CDN resources for icons and styles.
    |
    */

    'offline_mode' => env('OFFLINE_MODE', false),
    
    /*
    |--------------------------------------------------------------------------
    | CDN Resources
    |--------------------------------------------------------------------------
    |
    | URLs for CDN resources when offline mode is disabled
    |
    */
    'cdn' => [
        'lucide' => 'https://unpkg.com/lucide@latest',
        'tailwind' => 'https://cdn.tailwindcss.com',
        'fonts' => [
            'inter' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
            'unbounded' => 'https://fonts.googleapis.com/css2?family=Unbounded:wght@700&display=swap',
        ]
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Local Assets
    |--------------------------------------------------------------------------
    |
    | Paths to local assets when offline mode is enabled
    |
    */
    'local' => [
        'lucide' => 'assets/js/lucide.min.js',
        'tailwind' => 'assets/css/tailwind.min.css',
        'fonts' => [
            'inter' => 'assets/fonts/inter.css',
            'unbounded' => 'assets/fonts/unbounded.css',
        ]
    ]
];