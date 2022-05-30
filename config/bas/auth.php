<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Local storage field names for authenticating the logged in user
    |--------------------------------------------------------------------------
    */

    'local_storage' => [
        'username'  => env('BAS_LOCAL_STORAGE_USERNAME', 'bas_auth_token'),
        'password'  => env('BAS_LOCAL_STORAGE_PASSWORD', 'bas_auth_token_expires_at'),
        'user_hash' => env('BAS_LOCAL_STORAGE_USER_HASH', 'bas_user_hash'),
        'email'     => env('BAS_LOCAL_STORAGE_EMAIL', 'bas_email'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Login token number range for generating the random integer
    |--------------------------------------------------------------------------
    */

    'login_token_range' => [
        'min'  => 100000,
        'max'  => 999999,
        'size' => 6,
    ],

];
