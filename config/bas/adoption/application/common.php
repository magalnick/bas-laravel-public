<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration details for all applications
    |--------------------------------------------------------------------------
    |
    | This defines the form layout that will populate the common fields
    | present in all adoption applications, regardless of type.
    |
    */

    'animal_name' => [
        'id' => 'animal_name',
        'type' => 'text',
        'label' => 'Name of animal(s) you\'re interested in adopting',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'required|string|max:100',
        'is_required' => true,
        'success' => 'setMainPageHeaderForAnimalName',
    ],

    'is_old_enough' => [
        'id' => 'is_old_enough',
        'type' => 'checkbox',
        'label' => 'Are you 21 or older?',
        'validation' => 'checkbox',
        'validator' => 'required|boolean',
        'is_required' => true,
        'invalid_feedback' => 'You must be 21 or older to continue',
        'static_label' => [
            'No',
            'Yes',
        ],
    ],

    'government_id' => [
        'id' => 'government_id',
        'type' => 'text',
        'label' => 'Government ID number (e.g. driver license, passport, military, etc.)',
        'min' => 1,
        'max' => 40,
        'validation' => 'text',
        'validator' => 'required|string|max:40',
        'is_required' => true,
    ],

    'government_id_expires_at' => [
        'id' => 'government_id_expires_at',
        'type' => 'date',
        'label' => 'Expiration date',
        'min' => date('Y-m-d', time() - 86400 * 30),
        'max' => date('Y-m-d', time() + 86400 * 365 * 12),
        'validation' => 'date',
        'validator' => 'required|date_format:Y-m-d',
        'is_required' => true,
    ],

    'address_1' => [
        'id' => 'address_1',
        'type' => 'text',
        'label' => 'Street address',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'required|string|max:100',
        'is_required' => true,
    ],

    'address_2' => [
        'id' => 'address_2',
        'type' => 'text',
        'label' => 'Apt, suite, unit, building, floor, etc...',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'nullable|string|max:100',
        'is_required' => false,
    ],

    'city' => [
        'id' => 'city',
        'type' => 'text',
        'label' => 'City',
        'min' => 1,
        'max' => 50,
        'validation' => 'text',
        'validator' => 'required|string|max:50',
        'is_required' => true,
    ],

    'state' => [
        'id' => 'state',
        'type' => 'select',
        'label' => 'State',
        'list' => 'states',
        'validation' => 'state',
        'validator' => 'required|string|min:2|max:2',
        'is_required' => true,
    ],

    'zip_code' => [
        'id' => 'zip_code',
        'type' => 'number',
        'label' => 'Zip code',
        'min' => 0,
        'max' => 99999,
        'digits' => 5,
        'validation' => 'numeric',
        'validator' => 'required|numeric|digits:5',
        'is_required' => true,
    ],

    'phone_1' => [
        'id' => 'phone_1',
        'type' => 'phone',
        'label' => 'Primary phone number',
        'min' => 10,
        'max' => 17,
        'validation' => 'phone',
        'validator' => 'required|string|min:10|max:17',
        'is_required' => true,
    ],

    'phone_2' => [
        'id' => 'phone_2',
        'type' => 'phone',
        'label' => 'Secondary phone number',
        'min' => 10,
        'max' => 17,
        'validation' => 'phone',
        'validator' => 'required|string|min:10|max:17',
        'is_required' => true,
    ],

];
