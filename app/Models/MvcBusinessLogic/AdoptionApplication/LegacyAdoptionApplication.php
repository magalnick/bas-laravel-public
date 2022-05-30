<?php

namespace App\Models\MvcBusinessLogic\AdoptionApplication;

use App\Models\MvcBusinessLogic\AbstractModel;
use Illuminate\Http\Request;

class LegacyAdoptionApplication extends AbstractModel
{
    private $data;

    /**
     * LegacyAdoptionApplication constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->data = $this->parseRequest($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function parseRequest(Request $request)
    {
        $data = [];
        $request_all = $request->all();

        // hack in special case for the final confirmation checkbox if it wasn't checked
        if (!array_key_exists('Confirmation', $request_all) || trim($request_all['Confirmation']) === '') {
            $request_all['Confirmation_not'] = 'on';
        }

        // loop through just the keys instead of looping through request->all()
        // so that each key can be verified against request->get()
        foreach (array_keys($request_all) as $key) {
            if (in_array($key, $this->skipMe())) {
                continue;
            }

            // validate the key against request->get()
            // put in a special case for Confirmation_not, since it's not a GET variable
            $value = $request->get($key) ?? null;
            $value = filter_var($value, FILTER_SANITIZE_STRING);
            if ($key === 'Confirmation_not') {
                $value = 'on';
            }
            if (is_null($value)) {
                continue;
            }
            $value = trim($value);
            if ($value === '') {
                continue;
            }

            // pulling value from request->get() and running through filter_var still leaves the page vulnerable
            // hard-code in replacement of < and >
            $value = str_replace('<', '&lt;', $value);
            $value = str_replace('>', '&gt;', $value);

            list($key, $value) = $this->keyValueRemapper($key, $value);

            // set everything to an array so that things like checkboxes on the same question
            // can be grouped together under a single key / value set
            // "scalar" values will end up as an array of 1
            if (!isset($data[$key])) {
                $data[$key] = [];
            }
            $data[$key][] = $value;
        }

        return $data;
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    private function keyValueRemapper($key, $value)
    {
        switch ($key) {
            // simple key to question remap
            case 'DogName':
            case 'Name':
            case 'Over21':
            case 'License':
            case 'Exp':
            case 'Zip':
            case 'Phone':
            case 'Cell':
            case 'Bus':
            case 'NumPeople':
            case 'Ages':
            case 'Q_2':
            case 'Q_6_Landlord':
            case 'Q_6_Phone':
            case 'Q_7':
            case 'Q_9_A':
            case 'Q_9_C':
            case 'Q_12':
            case 'Q_14':
            case 'Q_15_A':
            case 'Q_15_B':
            case 'Q_16_A':
            case 'Q_16_C':
            case 'Q_17_NumDogs':
            case 'Q_17_NumCats':
            case 'Q_17_NumOthers':
            case 'Q_20_B':
            case 'Q_20_Vet':
            case 'Q_20_Phone':
            case 'Q_22_A':
            case 'Q_22_B':
            case 'Q_23_A':
            case 'Q_23_B':
            case 'Q_24_I':
            case 'Q_26':
            case 'Q_27':
            case 'Q_28':
            case 'Q_29':
            case 'Q_30':
                return $this->simpleKeyToQuestionRemap($key, $value);

            // radio button remap
            case 'Q_1':
            case 'Q_3':
            case 'Q_5_A':
            case 'Q_5_B':
            case 'Q_6':
            case 'Q_8':
            case 'Q_9_B':
            case 'Q_10':
            case 'Q_11':
            case 'Q_13':
            case 'Q_18':
            case 'Q_19':
            case 'Q_20_A':
            case 'Q_21':
                return $this->radioTranslateQuestionAndAnswer($key, $value);

            // checkbox question and answer remap
            case 'Q_4_A':
            case 'Q_4_B':
            case 'Q_4_C':
            case 'Q_4_D':
            case 'Q_4_E':
            case 'Q_4_F':
            case 'Q_16_B_A':
            case 'Q_16_B_B':
            case 'Q_16_B_C':
            case 'Q_16_B_D':
            case 'Q_16_B_E':
            case 'Q_16_B_F':
            case 'Q_16_B_G':
            case 'Q_24_A':
            case 'Q_24_B':
            case 'Q_24_C':
            case 'Q_24_D':
            case 'Q_24_E':
            case 'Q_24_F':
            case 'Q_24_G':
            case 'Q_24_H':
            case 'Q_25_A':
            case 'Q_25_B':
            case 'Q_25_C':
            case 'Q_25_D':
            case 'Q_25_E':
            case 'Confirmation':
            case 'Confirmation_not':
                return $this->checkboxQuestionAndAnswerRemap($key, $value);
            default:
                return [$key, $value];
        }
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    private function simpleKeyToQuestionRemap($key, $value)
    {
        $key_to_question_map = [
            'DogName' => 'Name of dog(s) you\'re interested in adopting',
            'Name' => 'Your name',
            'Over21' => 'Are you 21 or older?',
            'License' => 'California Drivers License #',
            'Exp' => 'Expiration date',
            'Zip' => 'Zip code',
            'Phone' => 'Home phone',
            'Cell' => 'Cell phone',
            'Bus' => 'Business phone',
            'NumPeople' => 'Number of people in your household',
            'Ages' => 'Ages of children under 21',
            'Q_2' => 'Do you agree to let a BAS representative do a home visit prior to adoption?',
            'Q_6_Landlord' => 'Landlord\'s name',
            'Q_6_Phone' => 'Landlord\'s phone number',
            'Q_7' => 'Are you or your spouse in the military?',
            'Q_9_A' => 'Do you have a yard?',
            'Q_9_C' => 'How high is the fence?',
            'Q_12' => 'Where will the dog be left when no one is home?',
            'Q_14' => 'Who will be responsible for the care of the dog?',
            'Q_15_A' => 'Are you willing to spend the time and effort to help this dog adjust to your home and lifestyle?',
            'Q_15_B' => 'How much time will you spend?',
            'Q_16_A' => 'Have you previously owned a dog?',
            'Q_16_C' => 'Please explain',
            'Q_17_NumDogs' => 'How many dogs do you currently have?',
            'Q_17_NumCats' => 'How many cats do you currently have?',
            'Q_17_NumOthers' => 'How many other animals do you currently have?',
            'Q_20_B' => 'May we use your vet as a reference?',
            'Q_20_Vet' => 'Vet\'s name',
            'Q_20_Phone' => 'Vet\'s phone number',
            'Q_22_A' => 'Have you ever housebroken a dog?',
            'Q_22_B' => 'How do you housebreak a dog?',
            'Q_23_A' => 'Dogs need daily exercise. How many times a day will you be able to walk your dog?',
            'Q_23_B' => 'For how long each time?',
            'Q_24_I' => 'Under what circumstances would you not keep the dog?',
            'Q_26' => 'Dogs have been known to dig holes, chew things up, bark, etc. How do you intend to handle these problems?',
            'Q_27' => 'How do you feel is the best way to discipline a dog?',
            'Q_28' => 'Dogs can incur as much as $10,000 in expenses (food, medical expenses) over an average (10 year) life span. Are you aware of these expenses?',
            'Q_29' => 'If your dog develops unforeseen health problems, there is a potential for considerable expense. Are you able to sustain this additional expense?',
            'Q_30' => 'If for any reason you are unable to keep this dog, do you agree to return it to The Baja Animal Sanctuary?',
        ];
        return [
            $key_to_question_map[$key],
            $value,
        ];
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    private function radioTranslateQuestionAndAnswer($key, $value)
    {
        $radio_translator = [
            'Q_1' => [
                'question' => 'Do you or anyone you live with have an allergy to dogs?',
                'answers' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'NA' => 'Don\'t know',
                ],
            ],
            'Q_3' => [
                'question' => 'Dog experience',
                'answers' => [
                    'A' => 'First time owner',
                    'B' => 'Have had one or two',
                    'C' => 'Knowledgeable & experienced',
                ],
            ],
            'Q_5_A' => [
                'question' => 'Type of dwelling',
                'answers' => [
                    'A' => 'House',
                    'B' => 'Apartment',
                    'C' => 'Condo',
                    'D' => 'Mobile Home',
                    'E' => 'Military',
                    'F' => 'Other',
                ],
            ],
            'Q_5_B' => [
                'question' => 'Dwelling ownership',
                'answers' => [
                    'A' => 'Rent',
                    'B' => 'Own',
                    'C' => 'Live with parents',
                    'D' => 'Military housing',
                ],
            ],
            'Q_6' => [
                'question' => 'If you rent, may we contact your landlord for confirmation that you are allowed to have a dog?',
                'answers' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'NA' => 'N/A',
                ],
            ],
            'Q_8' => [
                'question' => 'Home atmosphere',
                'answers' => [
                    'A' => 'Busy & noisy',
                    'B' => 'Some activity',
                    'C' => 'Quiet & Serene',
                ],
            ],
            'Q_9_B' => [
                'question' => 'Is the yard fenced?',
                'answers' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'NA' => 'N/A',
                ],
            ],
            'Q_10' => [
                'question' => 'What kind of dog is right for you?',
                'answers' => [
                    'A' => 'Highly energetic',
                    'B' => 'Somewhat energetic',
                    'C' => 'Calm',
                ],
            ],
            'Q_11' => [
                'question' => 'Where will the dog sleep?',
                'answers' => [
                    'A' => 'Inside the house',
                    'B' => 'In the garage',
                    'C' => 'Outside',
                ],
            ],
            'Q_13' => [
                'question' => 'How many hours per day will the dog be alone?',
                'answers' => [
                    'A' => 'All day',
                    'B' => 'Part of the day',
                    'C' => 'Rarely',
                ],
            ],
            'Q_18' => [
                'question' => 'Are all of your dogs current on their vaccines?',
                'answers' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'NA' => 'N/A',
                ],
            ],
            'Q_19' => [
                'question' => 'Have all of your dogs been spayed/neutered?',
                'answers' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'NA' => 'N/A',
                ],
            ],
            'Q_20_A' => [
                'question' => 'Do you currently have a vet?',
                'answers' => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                    'NA' => 'N/A',
                ],
            ],
            'Q_21' => [
                'question' => 'What do you do with your animals when you go on vacation?',
                'answers' => [
                    'A' => 'Neighbors take care of them',
                    'B' => 'Pet service',
                    'C' => 'Boarding',
                    'D' => 'House sitter',
                    'E' => 'Other',
                ],
            ],
        ];
        return [
            $radio_translator[$key]['question'],
            $radio_translator[$key]['answers'][$value],
        ];
    }

    private function checkboxQuestionAndAnswerRemap($key, $value)
    {
        $q_and_a_translator = [
            'Q_4_A' => [
                'question' => 'What is the reason you want a dog?',
                'answer' => 'Companion',
            ],
            'Q_4_B' => [
                'question' => 'What is the reason you want a dog?',
                'answer' => 'For my spouse',
            ],
            'Q_4_C' => [
                'question' => 'What is the reason you want a dog?',
                'answer' => 'Guard dog',
            ],
            'Q_4_D' => [
                'question' => 'What is the reason you want a dog?',
                'answer' => 'For my other pet(s)',
            ],
            'Q_4_E' => [
                'question' => 'What is the reason you want a dog?',
                'answer' => 'For my children',
            ],
            'Q_4_F' => [
                'question' => 'What is the reason you want a dog?',
                'answer' => 'Other',
            ],
            'Q_16_B_A' => [
                'question' => 'Where is the dog now?',
                'answer' => 'I still have it',
            ],
            'Q_16_B_B' => [
                'question' => 'Where is the dog now?',
                'answer' => 'I gave it away',
            ],
            'Q_16_B_C' => [
                'question' => 'Where is the dog now?',
                'answer' => 'I sold it',
            ],
            'Q_16_B_D' => [
                'question' => 'Where is the dog now?',
                'answer' => 'It strayed off',
            ],
            'Q_16_B_E' => [
                'question' => 'Where is the dog now?',
                'answer' => 'It was stolen',
            ],
            'Q_16_B_F' => [
                'question' => 'Where is the dog now?',
                'answer' => 'It died',
            ],
            'Q_16_B_G' => [
                'question' => 'Where is the dog now?',
                'answer' => 'Other',
            ],
            'Q_24_A' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'Divorce/marriage',
            ],
            'Q_24_B' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'New baby',
            ],
            'Q_24_C' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'Moving',
            ],
            'Q_24_D' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'Owner\'s illness',
            ],
            'Q_24_E' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'Behavioral problems',
            ],
            'Q_24_F' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'No time',
            ],
            'Q_24_G' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'Getting another pet',
            ],
            'Q_24_H' => [
                'question' => 'Under what circumstances would you not keep the dog?',
                'answer' => 'Other',
            ],
            'Q_25_A' => [
                'question' => 'Under what circumstances would you put your dog to sleep (euthanize)?',
                'answer' => 'Costly illness',
            ],
            'Q_25_B' => [
                'question' => 'Under what circumstances would you put your dog to sleep (euthanize)?',
                'answer' => 'Old age',
            ],
            'Q_25_C' => [
                'question' => 'Under what circumstances would you put your dog to sleep (euthanize)?',
                'answer' => 'Untreatable suffering',
            ],
            'Q_25_D' => [
                'question' => 'Under what circumstances would you put your dog to sleep (euthanize)?',
                'answer' => 'Uncorrectable behavioral problems',
            ],
            'Q_25_E' => [
                'question' => 'Under what circumstances would you put your dog to sleep (euthanize)?',
                'answer' => 'Other',
            ],
            'Confirmation' => [
                'question' => 'Final confirmation checkbox',
                'answer' => 'I have read this application and I understand the questions, the policies and the process. The Baja Animal Sanctuary reserves the right to refuse to adopt a dog to any person.',
            ],
            'Confirmation_not' => [
                'question' => 'Final confirmation checkbox',
                'answer' => 'I *did not* check the final confirmation checkbox.',
            ],
        ];
        return [
            $q_and_a_translator[$key]['question'],
            $q_and_a_translator[$key]['answer'],
        ];
    }

    /**
     * Skip these keys since they're sub-answers on an already answered main question.
     *
     * @return array
     */
    private function skipMe()
    {
        return [
            'Print',
            'Submitted',
            'Q_17_Dogs',
            'Q_17_Cats',
            'Q_17_Others',
        ];
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
