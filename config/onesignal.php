<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OneSignal Application ID & API Credentials
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OneSignal App ID and REST API Key.
    | These can be found in your OneSignal dashboard under Settings > Keys & IDs.
    |
    */

    'app_id' => env('ONESIGNAL_APP_ID'),

    'rest_api_key' => env('ONESIGNAL_REST_API_KEY'),

    'user_auth_key' => env('ONESIGNAL_USER_AUTH_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Safari Web ID
    |--------------------------------------------------------------------------
    |
    | Safari 16 and earlier requires a Safari Web ID to deliver web push notifications.
    | Safari 16.4+ supports standard Web Push API.
    |
    */

    'safari_web_id' => env('ONESIGNAL_SAFARI_WEB_ID'),

    /*
    |--------------------------------------------------------------------------
    | Default Push Notification Settings
    |--------------------------------------------------------------------------
    |
    | Default icons, badges, and landing URLs for push notifications.
    |
    */

    'defaults' => [
        'icon' => env('ONESIGNAL_DEFAULT_ICON', '/assets/favicon/android-chrome-192x192.png'),
        'badge' => env('ONESIGNAL_DEFAULT_BADGE', '/assets/favicon/favicon-32x32.png'),
        'url' => env('APP_URL', 'http://localhost'),
    ],

    /*
    |--------------------------------------------------------------------------
    | OneSignal Email Configuration
    |--------------------------------------------------------------------------
    |
    | Default sender settings when sending emails via OneSignal REST API.
    |
    */

    'email' => [
        'from_name' => env('ONESIGNAL_EMAIL_FROM_NAME', env('MAIL_FROM_NAME', 'Anywhereroles')),
        'from_address' => env('ONESIGNAL_EMAIL_FROM_ADDRESS', env('MAIL_FROM_ADDRESS', 'noreply@anywhereroles.com')),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Base URL & Timeout
    |--------------------------------------------------------------------------
    */

    'api_url' => env('ONESIGNAL_API_URL', 'https://onesignal.com/api/v1'),

    'timeout' => (int) env('ONESIGNAL_TIMEOUT', 15),

];
