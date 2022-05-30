<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dog adoptions
    |--------------------------------------------------------------------------
    */

    'dog' => [
        [
            'which' => '1st',
            'day' => 'Saturday',
            'location' => 'KahootsRanchoPenasquitos',
            'startTime' => '10:00am',
            'endTime' => '2:00pm',
            'contacts' => ['AnitaBoeker'],
        ],
        [
            'which' => '2nd',
            'day' => 'Saturday',
            'location' => 'KahootsRanchoPenasquitos',
            'startTime' => '10:00am',
            'endTime' => '2:00pm',
            'contacts' => ['AnitaBoeker'],
        ],
        [
            'which' => '3rd',
            'day' => 'Saturday',
            'location' => 'KahootsRanchoPenasquitos',
            'startTime' => '10:00am',
            'endTime' => '2:00pm',
            'contacts' => ['AnitaBoeker'],
        ],
        [
            'which' => '4th',
            'day' => 'Saturday',
            'location' => null,
        ],
        [
            'which' => '5th',
            'day' => 'Saturday',
            'location' => 'KahootsRanchoPenasquitos',
            'startTime' => '10:00am',
            'endTime' => '1:00pm',
            'contacts' => ['AnitaBoeker'],
            // 'note' => 'Puppies Only!',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cat adoptions
    |--------------------------------------------------------------------------
    */

    'cat' => [
        [
            'location' => 'BAS',
            'contacts' => ['JaimeVictorioMadera'],
        ],
        [
            'location' => 'VistaFosterHome',
            'contacts' => ['KathleenPaymard'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Adoption events page image list and other display details
    |--------------------------------------------------------------------------
    */

    'images' => [
        'dog' => [
            [
                'src'   => '/images/adoption-events/bas-adoption-event-main-table.jpg',
                'alt'   => 'Main adoption table at Kahoots in Rancho Penasquitos.',
                'style' => 'width: 100%; margin-top: 5px;',
            ],
            [
                'src'   => '/images/adoption-events/bas-adoption-event-dog-at-table-01.png',
                'alt'   => 'A puppy helping volunteer Rosa fill out paperwork at an adoption event.',
                'style' => 'width: 75%; min-width: 300px; margin-top: 20px;',
            ],
            [
                'src'   => '/images/adoption-events/bas-adoption-event-dog-at-table-02.png',
                'alt'   => 'Puppy and volunteer Cheri chilling together at an adoption event.',
                'style' => 'width: 75%; min-width: 300px; margin-top: 20px;',
            ],
            [
                'src'   => '/images/adoption-events/bas-adoption-event-dog-adopted.png',
                'alt'   => 'Adopted! Volunteer Bonnie cuddling her new baby girl.',
                'style' => 'width: 300px; margin-top: 20px;',
            ],
        ],
    ],

];
