<?php

return [

    /*
    |--------------------------------------------------------------------------
    | BAS - Main site Blade template name
    |--------------------------------------------------------------------------
    |
    | This is like the template driver file. As long as it's passed a $page
    | value corresponding to the main page content template, then it puts
    | the whole thing together.
    |
    */

    'main_site_blade_template' => 'site.baja-animal-sanctuary',
    'error_blade_template'     => 'errors.all',

    /*
    |--------------------------------------------------------------------------
    | BAS - Pages recognized as main with titles and possibly in navigation
    |--------------------------------------------------------------------------
    |
    | This lists out the main pages, including how they can show in the
    | navigation. To start, it will be just a one-dimensional list so there
    | won't be any nested links.
    |
    | If a page is defined in here, it should also have a corresponding web
    | route.
    |
    | Note that this is being called as a function so that the HTTP statuses
    | can all have corresponding dynamic views from a single Blade template.
    |
    */

    'pages' => getPagesArray(),

];

/**
 * @return array
 */
function getPagesArray()
{
    $pages = [
        'home' => [
            'id'                 => 'home',
            'path'               => '/',
            'title'              => env('APP_NAME', 'Baja Animal Sanctuary'),
            'show_in_navigation' => false,
        ],
        'env' => [
            'id'                 => 'env',
            'path'               => '/env',
            'title'              => 'Environment',
            'show_in_navigation' => env('SHOW_ENV_PAGE_LINK', false),
        ],
        'dogs' => [
            'id'                 => 'dogs',
            'path'               => '/dogs',
            'title'              => 'Dogs',
            'description'        => 'The Baja Animal Sanctuary conducts weekly dog adoptions in San Diego County.',
            'show_in_navigation' => true,
        ],
        'cats' => [
            'id'                 => 'cats',
            'path'               => '/cats',
            'title'              => 'Cats',
            'description'        => 'Our kitties are available for adoption full-time in a Vista, California foster home.',
            'show_in_navigation' => true,
        ],
        'about-us' => [
            'id'                 => 'about-us',
            'path'               => '/about-us',
            'title'              => 'About Us',
            'description'        => 'Baja Animal Sanctuary, the only no-kill shelter in northern Mexico, provides a safe haven for dogs and cats. We are located in Rosarito, Mexico, just 22 miles south of the San Ysidro border.',
            'show_in_navigation' => true,
        ],
        'adoption-events' => [
            'id'                 => 'adoption-events',
            'path'               => '/adoption-events',
            'title'              => 'Adoption Events',
            'description'        => 'The Baja Animal Sanctuary conducts weekly dog adoptions in San Diego County. Our kitties are available for adoption full-time in a Vista, California foster home.',
            'show_in_navigation' => true,
        ],
        'newsletter' => [
            'id'                 => 'newsletter',
            'path'               => '/newsletter',
            'title'              => 'Newsletter',
            'show_in_navigation' => true,
        ],
        'volunteering' => [
            'id'                 => 'volunteering',
            'path'               => '/volunteering',
            'title'              => 'Volunteering',
            'description'        => 'We are always in need of extra helpers to keep the Baja Animal Sanctuary running smoothly.',
            'show_in_navigation' => true,
        ],
        'gift-shop' => [
            'id'                 => 'gift-shop',
            'path'               => '/gift-shop',
            'title'              => 'Gift Shop',
            'description'        => 'What better way to help support the Baja Animal Sanctuary than by purchasing one of our fun products! They also make great gifts for friends and family.',
            'show_in_navigation' => true,
        ],
        'favorite-businesses' => [
            'id'                 => 'favorite-businesses',
            'path'               => '/favorite-businesses',
            'title'              => 'Favorite Businesses',
            'show_in_navigation' => true,
        ],
        'donate' => [
            'id'                 => 'donate',
            'path'               => '/donate',
            'title'              => 'Donate',
            'description'        => 'Thank you so much for your interest in helping the Baja Animal Sanctuary! It is your support that allows us to provide food, shelter, and medical care for the animals during their stay with us.',
            'show_in_navigation' => false,
        ],
        'adoption-applications' => [
            'id'                 => 'adoption-applications',
            'path'               => '/adoption-applications',
            'title'              => 'Adoption Application Overview',
            'show_in_navigation' => false,
        ],
        'adoption-application-by-token' => [
            'id'                 => 'adoption-application-by-token',
            'path'               => '/adoption-applications',
            'title'              => 'Adoption Application',
            'show_in_navigation' => false,
        ],
        'adoption-application-legacy' => [
            'id'                 => 'adoption-application-legacy',
            'path'               => '/application.asp',
            'title'              => 'Legacy Adoption Application',
            'show_in_navigation' => false,
        ],
    ];

    foreach (Illuminate\Http\Response::$statusTexts as $code => $status) {
        $pages[$code] = [
            'id'                 => $code,
            'path'               => "/{$code}",
            'title'              => "$code - $status",
            'show_in_navigation' => false,
        ];
    }

    return $pages;
}
