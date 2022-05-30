<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application types
    |--------------------------------------------------------------------------
    */

    'types' => [
        'dog',
        'cat',
        'chinchilla',
    ],

    /*
    |--------------------------------------------------------------------------
    | Adoption application email base subject
    |--------------------------------------------------------------------------
    */

    'email_base_subject' => env('ADOPTION_APPLICATION_EMAIL_BASE_SUBJECT'),

    /*
    |--------------------------------------------------------------------------
    | Lists to populate select menus or radio buttons
    |--------------------------------------------------------------------------
    |
    | Note that the keys for each list here will be used as allowable values
    | in the "validate" section of the configuration using this list.
    | So if anything changes here, it must be updated in the other configs.
    |
    |--------------------------------------------------------------------------
    */

    'lists' => [
        'no' => [
            'N' => 'No',
        ],
        'yes' => [
            'Y' => 'Yes',
        ],
        'yesNo' => [
            'Y' => 'Yes',
            'N' => 'No',
        ],
        'yesNoNa' => [
            'Y' => 'Yes',
            'N' => 'No',
            'NA' => 'N/A',
        ],
        'yesNoDunno' => [
            'Y' => 'Yes',
            'N' => 'No',
            'IDK' => 'I don\'t know',
        ],
        'dogExperience' => [
            'none' => 'First time owner',
            '1or2' => 'Have had one or two',
            'guru' => 'Knowledgeable & experienced',
        ],
        'dwellingType' => [
            'H' => 'House',
            'A' => 'Apartment',
            'C' => 'Condominium',
            'MH' => 'Mobile home',
            'M' => 'Military',
            'O' => 'Other',
        ],
        'dwellingStatus' => [
            'R' => 'Rent',
            'O' => 'Own',
            'P' => 'Live with parents',
            'M' => 'Military housing',
        ],
        'homeAtmosphere' => [
            'B' => 'Busy & noisy',
            'S' => 'Some activity',
            'Q' => 'Quiet & serene',
        ],
        'energyLevel' => [
            'H' => 'Highly energetic',
            'S' => 'Somewhat energetic',
            'C' => 'Calm',
        ],
        'whereSleep' => [
            'H' => 'Inside the house',
            'G' => 'In the garage',
            'O' => 'Outside',
        ],
        'isAlone' => [
            'A' => 'All day',
            'P' => 'Part of the day',
            'R' => 'Rarely',
        ],
        'vacationCaregiver' => [
            'N' => 'Neighbors take care of them',
            'P' => 'Pet service',
            'B' => 'Boarding',
            'H' => 'House sitter',
            'O' => 'Other',
        ],
    ],

];
