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

    'sendinblue' => [
        // api-key or partner-key
        'key_identifier' => env('SENDINBLUE_KEY_IDENTIFIER', 'api-key'),
        'key' => env('SENDINBLUE_KEY'),
        'api' => [
            'base_url' => env('SENDINBLUE_API_BASE_URL'),
        ],
        'templates' => [
            'login_token' => [
                'id' => env('SENDINBLUE_EMAIL_TEMPLATE_ID_LOGIN_TOKEN'),
            ],
            'submit_adoption_application' => [
                'id' => env('SENDINBLUE_EMAIL_TEMPLATE_ID_SUBMIT_ADOPTION_APPLICATION'),
            ],
        ],
    ],

    'google' => [
        'recaptcha' => [
            'site_key'   => env('RECAPTCHA_SITE_KEY'),
            'secret_key' => env('RECAPTCHA_SECRET_KEY'),
            'error_codes' => [
                'missing-input-secret'   => 'The secret parameter is missing.',
                'invalid-input-secret'   => 'The secret parameter is invalid or malformed.',
                'missing-input-response' => 'The response parameter is missing.',
                'invalid-input-response' => 'The response parameter is invalid or malformed.',
                'bad-request'            => 'The request is invalid or malformed.',
                'timeout-or-duplicate'   => 'The response is no longer valid: either is too old or has been used previously.',
            ],
        ],
    ],

];
