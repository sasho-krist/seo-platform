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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        'url' => env('OPENAI_API_URL', 'https://api.openai.com/v1/chat/completions'),
        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        'verify_ssl' => filter_var(env('OPENAI_VERIFY_SSL', true), FILTER_VALIDATE_BOOLEAN),
        'cacert' => env('OPENAI_CACERT', 'ssl/cacert.pem'),
    ],

    /*
    | Outgoing HTTPS from this app (URL fetch, WordPress REST, …).
    | Falls back to OPENAI_VERIFY_SSL / OPENAI_CACERT when unset so one .env fixes local dev.
    */
    'outbound_http' => [
        'verify_ssl' => filter_var(env('HTTP_VERIFY_SSL', env('OPENAI_VERIFY_SSL', true)), FILTER_VALIDATE_BOOLEAN),
        'cacert' => env('HTTP_CACERT', env('OPENAI_CACERT', 'ssl/cacert.pem')),
    ],

];
