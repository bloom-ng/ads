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

    'whatsapp' => [
        'verify_token' => env('WHATSAPP_VERIFY_TOKEN'),
        'app_secret' => env('WHATSAPP_APP_SECRET'),
        'private_key_content' => env('WHATSAPP_PRIVATE_KEY_CONTENT'),
        'private_key_passphrase' => env('WHATSAPP_PRIVATE_KEY_PASSPHRASE'),
        // Sending config
        'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        // Template details (flows-as-template)
        'template_name' => env('WHATSAPP_TEMPLATE_NAME'),
        'template_language' => env('WHATSAPP_TEMPLATE_LANGUAGE', 'en_US'),
        // Optional: direct flow send (interactive flow)
        'flow_id' => env('WHATSAPP_FLOW_ID'),
        'flow_name' => env('WHATSAPP_FLOW_NAME'),
    ],

];
