<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Basic details on BAS
    |--------------------------------------------------------------------------
    */

    'name' => env('APP_NAME', 'Baja Animal Sanctuary'),

    'mailing_address' => [
        'address_1' => '10606 Camino Ruiz, Suite 8, PMB# 172',
        'city'      => 'San Diego',
        'state'     => 'CA',
        'zipcode'   => '92126',
        'zipcode_9' => '92126-3263',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sanctuary hours
    |--------------------------------------------------------------------------
    */

    'sanctuary_hours' => [
        //'Weekdays: 10:00 AM to 3:00 PM',
        //'Weekend: 10:00 AM to 2:00 PM',
        //'After Hours: By Appointment Only',
        'Contact us to make an appointment to come visit.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Some extras like federal tax ID, etc...
    |--------------------------------------------------------------------------
    */

    'tagline'              => 'On behalf of those who have no voice',
    'tax_id'               => '33-0958137',
    'mission_statement'    => 'To provide a safe haven for the abused, abandoned and needy animals who enter our gates, to eliminate their suffering, to improve their quality of life, to reduce pet overpopulation by spaying and neutering, and to find them permanent, safe, loving homes.',
    'show_covid_content'   => env('SHOW_COVID_CONTENT', false),
    'newsletter_directory' => env('NEWSLETTER_DIRECTORY', 'public/newsletters'),
    'allow_robots_txt'     => (bool) env('ALLOW_ROBOTS_TXT', false),

    /*
    |--------------------------------------------------------------------------
    | Social media
    |--------------------------------------------------------------------------
    */

    'social_media' => [
        'facebook' => [
            'platform'    => 'Facebook',
            'url'         => 'https://www.facebook.com/bajaanimalsanctuary',
            'tagline'     => 'Like us on Facebook',
            'fontawesome' => 'facebook fa fa-facebook-square',
        ],
        'instagram' => [
            'platform'    => 'Instagram',
            'url'         => 'https://www.instagram.com/baja_animal_sanctuary/',
            'tagline'     => 'Follow us on Instagram',
            'fontawesome' => 'instagram fa fa-instagram',
        ],
        'mailing_list' => [
            'platform'    => 'MailingList',
            'url'         => 'https://mailchi.mp/1cf92853649c/bas-signup',
            'tagline'     => 'Subscribe to BAS e-News',
            'fontawesome' => 'subscribe-to-e-news fa fa-envelope-o',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Marketing things like newsletter signup
    |--------------------------------------------------------------------------
    */

    'marketing' => [
        'newsletter_signup_url_external' => 'https://mailchi.mp/1cf92853649c/bas-signup',
    ],

    /*
    |--------------------------------------------------------------------------
    | Disclaimers
    |--------------------------------------------------------------------------
    |
    | Various disclaimers for use around the site.
    |
    */

    'disclaimers' => [
        'basic' => [
            '501c3' => 'The Baja Animal Sanctuary is a 501(c)(3), not-for-profit corporation qualified to receive tax-deductible contributions and is funded solely by generous individuals like you.',
            'privacy' => 'Your privacy is very important to us. Any personal information collected by BAS will be held in strict confidence.',
        ],
        'donation' => [
            '501c3'   => 'The Baja Animal Sanctuary is a 501(c)(3), not-for-profit corporation qualified to receive tax-deductible contributions and is funded solely by generous individuals like you. For your tax records, a receipt for your donation will be mailed to you.',
            'privacy' => 'Your privacy is very important to us. Any personal information collected by BAS as a result of this donation transaction will be held in strict confidence.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Placement statistics
    |--------------------------------------------------------------------------
    */

    'placement_statistics' => [
        '2021' => [
            'placed' => [
                'dogs' => 417,
                'cats' => 56,
            ],
            'took_in' => [
                'dogs' => 469,
                'cats' => 63,
            ],
            'currently_have' => [
                'dogs' => 215,
                'cats' => 77,
            ],
            'sterilized'         => 487,
            'spay_neuter_clinic' => 360,
        ],
        '2020' => [
            'placed' => [
                'dogs' => 398,
                'cats' => 51,
            ],
            'took_in' => [
                'dogs' => 213,
                'cats' => 38,
            ],
            'currently_have' => [
                'dogs' => 189,
                'cats' => 58,
            ],
            'sterilized'         => 378,
            'spay_neuter_clinic' => 200,
        ],
    ],

];
