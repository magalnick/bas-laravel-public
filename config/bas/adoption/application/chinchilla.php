<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration details for a "chinchilla" application
    |--------------------------------------------------------------------------
    |
    | This defines the form layout that will populate the `object_data` field
    | in the `adoption_applications` database table.
    |
    | Note that since this will be representing a JSON object in a big data
    | field, there is no default value set coming out of the database.
    | Therefore there needs to be a 'default_value' key in each set that is not
    | needed in the "common" file.
    | This default value can be anything as needed, like integer, string,
    | boolean, array, etc..., whatever will be needed for populating a form.
    |
    */

    'disclaimer_right_to_refuse' => [
        'id' => 'disclaimer_right_to_refuse',
        'type' => 'select',
        'label' => 'Do you understand that The Baja Animal Sanctuary reserves the right to refuse to adopt a chinchilla to any person?',
        'list' => 'yes',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y',
        'is_required' => true,
    ],

];
