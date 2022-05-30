<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// begin routes defined in the config(view.pages) list
Route::get('/', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page' => 'home',
    ]);
});

Route::get('/home', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page' => 'home',
    ]);
});

Route::get('/dogs', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page'     => 'dogs',
        'dogs'     => config('bas.dogs'),
        'adoption' => config('bas.adoption'),
    ]);
});

Route::get('/cats', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page'     => 'cats',
        'js'       => 'cats',
        'adoption' => config('bas.adoption'),
        'contacts' => config('bas.contacts'),
    ]);
});

Route::get('/about-us', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page'     => 'about-us',
        'about_us' => config('bas.about-us'),
    ]);
});

Route::get('/adoption-events', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page' => 'adoption-events',
    ]);
});

Route::get('/newsletter',
    [
        App\Http\Controllers\NewslettersController::class,
        'view'
    ]
)->name('newsletter');

Route::get('/volunteering', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page'               => 'volunteering',
        'contacts'           => config("bas.contacts"),
        'volunteer_contacts' => config('bas.contacts.volunteering'),
    ]);
});

Route::get('/gift-shop', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page'      => 'gift-shop',
        'gift_shop' => config('bas.gift-shop'),
    ]);
});

Route::get('/favorite-businesses', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page'                => 'favorite-businesses',
        'js'                  => 'favorite-businesses',
        'favorite_businesses' => config('bas.favorite-businesses'),
    ]);
});

Route::get('/donate', function () {
    $contact_id = config('bas.adoption.main_contact.dog');
    return view(config('bas.view.main_site_blade_template'), [
        'page'    => 'donate',
        'contact' => config("bas.contacts.{$contact_id}"),
    ]);
});

Route::get('/application.asp',
    [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'legacy'
    ]
)->name('adoption-application-legacy');

Route::get('/adoption-applications',
    [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'view'
    ]
)->name('adoption-applications');

Route::get('/adoption-applications/{token}',
    [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'viewApplication'
    ]
)->name('adoption-applications/{token}');

Route::get('/adoption-applications/{token}/print',
    [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'printApplication'
    ]
)->name('adoption-applications/{token}/print');

Route::get('/env', function () {
    return view(config('bas.view.main_site_blade_template'), [
        'page' => 'env',
        'app_environment' => env('APP_ENV'),
    ]);
});
// end routes defined in the config(view.pages) list

// begin "static" routes
Route::get('/robots.txt',
    [
        App\Http\Controllers\StaticController::class,
        'robotsTxt'
    ]
)->name('robots-txt');
// end "static" routes

// begin legacy redirects
foreach (config('bas.legacy.redirects') as $redirect) {
    Route::get($redirect['old'], function() use ($redirect) {
        header("Location: {$redirect['new']}");
        return;
    });
}
// end legacy redirects

Route::get('/welcome', function () {
    return view('welcome');
});

//Route::get('/phpinfo', function () { phpinfo(); exit; });

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
