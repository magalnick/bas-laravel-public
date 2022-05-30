<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration details for a "dog" application
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

    'household_size' => [
        'id' => 'household_size',
        'type' => 'number',
        'label' => 'Number of people in your household',
        'default_value' => '',
        'min' => 1,
        'max' => 20,
        'validation' => 'numeric',
        'validator' => 'required|numeric|min:1|max:20',
        'is_required' => true,
    ],

    'ages_of_children' => [
        'id' => 'ages_of_children',
        'type' => 'text',
        'label' => 'Ages of children under 21',
        'default_value' => '',
        'min' => 1,
        'max' => 50,
        'validation' => 'text',
        'validator' => 'nullable|string|max:50',
        'is_required' => false,
    ],

    'dog_allergies' => [
        'id' => 'dog_allergies',
        'type' => 'select',
        'label' => 'Do you or anyone you live with have an allergy to dogs?',
        'list' => 'yesNoDunno',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N,IDK',
        'is_required' => true,
    ],

    'allow_home_visit' => [
        'id' => 'allow_home_visit',
        'type' => 'select',
        'label' => 'Do you agree to let a BAS representative do a home visit prior to adoption?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'dog_experience' => [
        'id' => 'dog_experience',
        'type' => 'select',
        'label' => 'What is your prior dog experience?',
        'list' => 'dogExperience',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:none,1or2,guru',
        'is_required' => true,
    ],

    'why_want_dog' => [
        'id' => 'why_want_dog',
        'type' => 'checkbox_group',
        'label' => 'What is the reason you want a dog?',
        'validation' => 'checkbox_group',
        'validator' => 'required|array',
        'is_required' => true,
        'invalid_feedback' => 'You must select at least 1 answer',
        'static_labels' => [
            'Companion',
            'For my spouse',
            'Guard dog',
            'For my other pet(s)',
            'For my children',
            'Other',
        ],
    ],

    'dwelling_type' => [
        'id' => 'dwelling_type',
        'type' => 'select',
        'label' => 'In what type of dwelling do you live?',
        'list' => 'dwellingType',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:H,A,C,MH,M,O',
        'is_required' => true,
    ],

    'dwelling_status' => [
        'id' => 'dwelling_status',
        'type' => 'select',
        'label' => 'What is your status there?',
        'list' => 'dwellingStatus',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:R,O,P,M',
        'is_required' => true,
    ],

    'landlord_may_we_contact' => [
        'id' => 'landlord_may_we_contact',
        'type' => 'select',
        'label' => 'If you rent, may we contact your landlord for confirmation that you are allowed to have a dog?',
        'list' => 'yesNoNa',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N,NA',
        'is_required' => true,
    ],

    'landlord_name' => [
        'id' => 'landlord_name',
        'type' => 'text',
        'label' => 'Landlord\'s name',
        'default_value' => '',
        'min' => 1,
        'max' => 50,
        'validation' => 'text',
        'validator' => 'nullable|string|max:50',
        'is_required' => false,
    ],

    'landlord_phone' => [
        'id' => 'landlord_phone',
        'type' => 'phone',
        'label' => 'Landlord\'s phone number',
        'default_value' => '',
        'min' => 10,
        'max' => 17,
        'validation' => 'phone',
        'validator' => 'nullable|string|min:10|max:17',
        'is_required' => false,
    ],

    'anyone_in_military' => [
        'id' => 'anyone_in_military',
        'type' => 'select',
        'label' => 'Are you or your spouse in the military?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'home_atmosphere' => [
        'id' => 'home_atmosphere',
        'type' => 'select',
        'label' => 'What is the atmosphere in your home?',
        'list' => 'homeAtmosphere',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:B,S,Q',
        'is_required' => true,
    ],

    'have_yard' => [
        'id' => 'have_yard',
        'type' => 'select',
        'label' => 'Do you have a yard?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'have_yard_fenced' => [
        'id' => 'have_yard_fenced',
        'type' => 'select',
        'label' => 'Is the yard fenced?',
        'list' => 'yesNoNa',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N,NA',
        'is_required' => true,
    ],

    'fence_height' => [
        'id' => 'fence_height',
        'type' => 'text',
        'label' => 'How high is the fence?',
        'default_value' => '',
        'min' => 1,
        'max' => 20,
        'validation' => 'text',
        'validator' => 'nullable|string|max:20',
        'is_required' => false,
    ],

    'energy_level' => [
        'id' => 'energy_level',
        'type' => 'select',
        'label' => 'What kind of dog is right for you?',
        'list' => 'energyLevel',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:H,S,C',
        'is_required' => true,
    ],

    'where_sleep' => [
        'id' => 'where_sleep',
        'type' => 'select',
        'label' => 'Where will the dog sleep?',
        'list' => 'whereSleep',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:H,G,O',
        'is_required' => true,
    ],

    'where_when_alone' => [
        'id' => 'where_when_alone',
        'type' => 'text',
        'label' => 'Where will the dog be left when no one is home?',
        'default_value' => '',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'required|string|max:100',
        'is_required' => true,
    ],

    'isAlone' => [
        'id' => 'isAlone',
        'type' => 'select',
        'label' => 'How many hours per day will the dog be alone?',
        'list' => 'isAlone',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:A,P,R',
        'is_required' => true,
    ],

    'who_responsible_for_care' => [
        'id' => 'who_responsible_for_care',
        'type' => 'text',
        'label' => 'Who will be responsible for the care of the dog?',
        'default_value' => '',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'required|string|max:100',
        'is_required' => true,
    ],

    'will_spend_time_to_adjust' => [
        'id' => 'will_spend_time_to_adjust',
        'type' => 'select',
        'label' => 'Are you willing to spend the time and effort to help this dog adjust to your home and lifestyle?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'how_much_spend_time_to_adjust' => [
        'id' => 'how_much_spend_time_to_adjust',
        'type' => 'text',
        'label' => 'How much time?',
        'default_value' => '',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'required|string|max:100',
        'is_required' => true,
    ],

    'previously_had_dog' => [
        'id' => 'previously_had_dog',
        'type' => 'select',
        'label' => 'Have you previously owned a dog?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'previously_had_dog_yes_what_happened' => [
        'id' => 'previously_had_dog_yes_what_happened',
        'type' => 'checkbox_group',
        'label' => 'What happened to it?',
        'validation' => 'checkbox_group',
        'validator' => 'required|array',
        'is_required' => true,
        'invalid_feedback' => 'You must select at least 1 answer',
        'static_labels' => [
            'Still have it',
            'Gave it away',
            'Sold it',
            'Strayed off',
            'Stolen',
            'Died',
            'Other',
            'N/A - I have not previously owned a dog',
        ],
    ],

    'previously_had_dog_yes_other_explain' => [
        'id' => 'previously_had_dog_yes_other_explain',
        'type' => 'text',
        'label' => 'Please explain if you selected "Other":',
        'default_value' => '',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'nullable|string|max:100',
        'is_required' => false,
    ],

    'how_many_now_dogs' => [
        'id' => 'how_many_now_dogs',
        'type' => 'number',
        'label' => 'How many dogs do you currently have?',
        'default_value' => 0,
        'min' => 0,
        'max' => 10,
        'validation' => 'numeric',
        'validator' => 'required|numeric|min:0|max:10',
        'is_required' => true,
    ],

    'how_many_now_cats' => [
        'id' => 'how_many_now_cats',
        'type' => 'number',
        'label' => 'How many cats do you currently have?',
        'default_value' => 0,
        'min' => 0,
        'max' => 10,
        'validation' => 'numeric',
        'validator' => 'required|numeric|min:0|max:10',
        'is_required' => true,
    ],

    'how_many_now_other' => [
        'id' => 'how_many_now_other',
        'type' => 'number',
        'label' => 'How many other pets do you currently have?',
        'default_value' => 0,
        'min' => 0,
        'max' => 50,
        'validation' => 'numeric',
        'validator' => 'required|numeric|min:0|max:50',
        'is_required' => true,
    ],

    'vaccines_current' => [
        'id' => 'vaccines_current',
        'type' => 'select',
        'label' => 'Are all of your dogs current on their vaccines?',
        'list' => 'yesNoNa',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N,NA',
        'is_required' => true,
    ],

    'spayed_neutered' => [
        'id' => 'spayed_neutered',
        'type' => 'select',
        'label' => 'Have all of your dogs been spayed or neutered?',
        'list' => 'yesNoNa',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N,NA',
        'is_required' => true,
    ],

    'vet_currently_have' => [
        'id' => 'vet_currently_have',
        'type' => 'select',
        'label' => 'Do you currently have a vet?',
        'list' => 'yesNoNa',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N,NA',
        'is_required' => true,
    ],

    'vet_use_as_reference' => [
        'id' => 'vet_use_as_reference',
        'type' => 'select',
        'label' => 'May we use your vet as a reference?',
        'list' => 'yesNoNa',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N,NA',
        'is_required' => true,
    ],

    'vet_name' => [
        'id' => 'vet_name',
        'type' => 'text',
        'label' => 'Vet\'s name',
        'default_value' => '',
        'min' => 1,
        'max' => 50,
        'validation' => 'text',
        'validator' => 'nullable|string|max:50',
        'is_required' => false,
    ],

    'vet_phone' => [
        'id' => 'vet_phone',
        'type' => 'phone',
        'label' => 'Vet\'s phone number',
        'default_value' => '',
        'min' => 10,
        'max' => 17,
        'validation' => 'phone',
        'validator' => 'nullable|string|min:10|max:17',
        'is_required' => false,
    ],

    'vacation_caregiver' => [
        'id' => 'vacation_caregiver',
        'type' => 'select',
        'label' => 'What do you do with your animals when you go on vacation?',
        'list' => 'vacationCaregiver',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:N,P,B,H,O',
        'is_required' => true,
    ],

    'previously_housebroken_dog' => [
        'id' => 'previously_housebroken_dog',
        'type' => 'select',
        'label' => 'Have you ever housebroken a dog?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'how_housebreak_dog' => [
        'id' => 'how_housebreak_dog',
        'type' => 'textarea',
        'label' => 'How do you housebreak a dog?',
        'default_value' => '',
        'min' => 1,
        'max' => 200,
        'validation' => 'text',
        'validator' => 'required|string|max:200',
        'is_required' => true,
    ],

    'daily_walks_how_many' => [
        'id' => 'daily_walks_how_many',
        'type' => 'number',
        'label' => 'Dogs need daily exercise. How many times a day will you be able to walk your dog?',
        'default_value' => '',
        'min' => 1,
        'max' => 20,
        'validation' => 'numeric',
        'validator' => 'required|numeric|min:1|max:20',
        'is_required' => true,
    ],

    'daily_walks_how_long_each' => [
        'id' => 'daily_walks_how_long_each',
        'type' => 'text',
        'label' => 'For how long each time?',
        'default_value' => '',
        'min' => 1,
        'max' => 50,
        'validation' => 'text',
        'validator' => 'required|string|max:50',
        'is_required' => true,
    ],

    'why_not_keep_dog' => [
        'id' => 'why_not_keep_dog',
        'type' => 'checkbox_group',
        'label' => 'Under what circumstances would you not keep the dog?',
        'validation' => 'checkbox_group',
        'validator' => 'required|array',
        'is_required' => true,
        'invalid_feedback' => 'You must select at least 1 answer',
        'static_labels' => [
            'None - I\'m keeping the dog no matter what',
            'Divorce/marriage',
            'New baby',
            'Moving',
            'Owner\'s illness',
            'Behavioral problems',
            'No time',
            'Getting another pet',
            'Other',
        ],
    ],

    'why_not_keep_dog_explain' => [
        'id' => 'why_not_keep_dog_explain',
        'type' => 'text',
        'label' => 'Please explain if you selected "Other":',
        'default_value' => '',
        'min' => 1,
        'max' => 100,
        'validation' => 'text',
        'validator' => 'nullable|string|max:100',
        'is_required' => false,
    ],

    'why_euthanize' => [
        'id' => 'why_euthanize',
        'type' => 'checkbox_group',
        'label' => 'Under what circumstances would you put your dog to sleep (euthanize)?',
        'validation' => 'checkbox_group',
        'validator' => 'required|array',
        'is_required' => true,
        'invalid_feedback' => 'You must select at least 1 answer',
        'static_labels' => [
            'Costly illness',
            'Old Age',
            'Untreatable suffering',
            'Uncorrectable behavioral problems',
            'Other',
        ],
    ],

    'how_handle_bark_dig_chew' => [
        'id' => 'how_handle_bark_dig_chew',
        'type' => 'textarea',
        'label' => 'Dogs have been known to dig holes, chew things up, bark, etc. How do you intend to handle these problems?',
        'default_value' => '',
        'min' => 1,
        'max' => 200,
        'validation' => 'text',
        'validator' => 'required|string|max:200',
        'is_required' => true,
    ],

    'how_discipline' => [
        'id' => 'how_discipline',
        'type' => 'textarea',
        'label' => 'How do you feel is the best way to discipline a dog?',
        'default_value' => '',
        'min' => 1,
        'max' => 200,
        'validation' => 'text',
        'validator' => 'required|string|max:200',
        'is_required' => true,
    ],

    'aware_of_expenses' => [
        'id' => 'aware_of_expenses',
        'type' => 'select',
        'label' => 'Dogs can incur $10,000 or more in expenses (food, medical expenses) over an average 10+ year life span. Are you aware of these expenses?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'can_sustain_expenses' => [
        'id' => 'can_sustain_expenses',
        'type' => 'select',
        'label' => 'If your dog develops unforeseen health problems, there is a potential for considerable expense. Are you able to sustain this additional expense?',
        'list' => 'yesNo',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y,N',
        'is_required' => true,
    ],

    'return_to_bas' => [
        'id' => 'return_to_bas',
        'type' => 'select',
        'label' => 'If for any reason you are unable to keep this dog, do you agree to return it to The Baja Animal Sanctuary?',
        'list' => 'yes',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y',
        'is_required' => true,
    ],

    'disclaimer_read_and_understand_application' => [
        'id' => 'disclaimer_read_and_understand_application',
        'type' => 'select',
        'label' => 'Have you read this application, and do you understand the questions, the policies, and the process?',
        'list' => 'yes',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y',
        'is_required' => true,
    ],

    'disclaimer_right_to_refuse' => [
        'id' => 'disclaimer_right_to_refuse',
        'type' => 'select',
        'label' => 'Do you understand that The Baja Animal Sanctuary reserves the right to refuse to adopt a dog to any person?',
        'list' => 'yes',
        'default_value' => '',
        'validation' => 'text',
        'validator' => 'required|in:Y',
        'is_required' => true,
    ],

];
