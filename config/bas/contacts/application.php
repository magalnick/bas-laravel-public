<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Adoption application administrators
    |--------------------------------------------------------------------------
    */

    'administrators' => [
        'dog' => [
            'DavidMagalnick',
            'MadMarye',
            'AnitaBoeker',
            'AnitaBoekerMobile',
            'JudySobel',
            'JudySobelYahoo',
        ],
        'cat' => [
            'DavidMagalnick',
            'MadMarye',
            'KathleenPaymard',
        ],
        'chinchilla' => [
            'DavidMagalnick',
            'MadMarye',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Adoption application email recipients
    |--------------------------------------------------------------------------
    */

    'email_recipients' => [
        'dog'        => env('ADOPTION_APPLICATION_EMAIL_RECIPIENT_DOG'),
        'cat'        => env('ADOPTION_APPLICATION_EMAIL_RECIPIENT_CAT'),
        'chinchilla' => env('ADOPTION_APPLICATION_EMAIL_RECIPIENT_CHINCHILLA'),
    ],

];
