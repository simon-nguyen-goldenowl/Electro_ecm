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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'pusher' => [
        'beams_instance_id' => 'afea1aa9-03e9-4409-8661-76fd562baf28',
        'beams_secret_key' => '17AAF8B79E4ED17D10AF8670924664AE665BB0FCFB61B4F82D6DA3DDC7D91637',
    ],
    'onesignal' => [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'rest_api_key' => env('ONESIGNAL_REST_API_KEY')
    ],
    'google' => [
        'client_id' => '813471872748-gppd7pg4rejg0bu9d8lfq9v2uoqgm2a5.apps.googleusercontent.com',
        'client_secret' => 'gWWNlHJtFA_op1TpL64DK7Hq',
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ],

];
