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

    'google' => [
        'client_id' => '408226004022-3rogvepk2puhg9khh2dlo16o31d6o1ph.apps.googleusercontent.com',
        'client_secret' => 'OKHc8_4B9eOxDWmEQDSuZBvL',
        'redirect' => 'https://phone.revonepal.com/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '854060281834400',
        'client_secret' => '88f4b76ec85baf875fa2151390df5d30',
        'redirect' => 'https://phone.revonepal.com/auth/facebook/callback',
    ],

];
