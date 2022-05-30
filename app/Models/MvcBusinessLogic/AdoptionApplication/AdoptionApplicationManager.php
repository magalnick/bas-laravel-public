<?php

namespace App\Models\MvcBusinessLogic\AdoptionApplication;

use App\Domain\SendMail\SendinBlue;
use App\Http\Response;
use App\Models\MvcBusinessLogic\AbstractModel;
use App\Utilities\Geography;
use App\ValueObjects\PhoneNumber;
use Illuminate\Http\Request;
use App\Utilities\FunWithText;
use App\Models\Database\AdoptionApplication;
use DateTime;
use Exception;
use App\Exceptions\ArrayException;
use Validator;

class AdoptionApplicationManager extends AbstractModel
{
    private static $instance = null;

    private $adoption_application;
    private $application_default_date = '1970-01-01 00:00:01';

    // substr(md5('AdoptionApplicationManager'), 0, 6)
    private $error_prefix = 'b9ea61';

    /**
     * @param AdoptionApplication $adoption_application
     * @param Request $request
     * @return AdoptionApplicationManager
     */
    public static function singleton(AdoptionApplication $adoption_application, Request $request)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($adoption_application, $request);
        }

        return self::$instance;
    }

    /**
     * AdoptionApplicationManager constructor.
     * @param AdoptionApplication $adoption_application
     * @param Request $request
     */
    private function __construct(AdoptionApplication $adoption_application, Request $request)
    {
        parent::__construct($request);
        $this->adoption_application = $adoption_application;
    }

    /**
     * @param string $action
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws Exception
     */
    public function setApplicationStatus($action = '')
    {
        if (!is_string($action)) {
            $action = '';
        }
        $action = trim($action);

        switch ($action) {
            case 'submit':
                return $this->submitApplication();
            case 'archive':
                return $this->archiveApplication();
            case 'reopen':
                return $this->reopenApplication();
            default:
                throw new Exception("Invalid action: {$action}", 400);
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws Exception
     */
    protected function submitApplication()
    {
        try {
            $this
                ->validateAllFields()
                ->sendSubmitAdoptionApplicationEmail();

            $this->adoption_application->submitted_at = date('Y-m-d H:i:s');
            $this->adoption_application->archived_at = $this->application_default_date;
            $this->adoption_application->save();
            return Response::success(['Adoption application successfully submitted.']);
        } catch (ArrayException $e) {
            return Response::errors(
                $e->getMessages(),
                $e->getCode()
            );
        } catch (Exception $e) {
            return Response::error(
                "({$this->error_prefix}) {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function archiveApplication()
    {
        $this->adoption_application->archived_at = date('Y-m-d H:i:s');
        $this->adoption_application->save();
        return Response::success(['Adoption application successfully archived.']);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function reopenApplication()
    {
        $this->adoption_application->submitted_at = $this->application_default_date;
        $this->adoption_application->archived_at = $this->application_default_date;
        $this->adoption_application->save();
        return Response::success(['Adoption application successfully reopened.']);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws Exception
     */
    public function saveField()
    {
        $type  = $this->request->post('type')  ?? null;
        $field = $this->request->post('field') ?? null;
        $value = $this->request->post('value') ?? null;

        if (!is_null($type)) {
            $type = FunWithText::safeString($type);
        }
        if (!is_null($field)) {
            $field = FunWithText::safeString($field);
        }

        $value = $this->validateIncomingData(
            $type,
            $field,
            $value
        );

        if (trim($type) === 'common') {
            return $this->saveFieldCommon($field, $value);
        }

        return $this->saveFieldObjectData($field, $value);
    }

    /**
     * @return $this
     * @throws ArrayException
     */
    public function validateAllFields()
    {
        $errors               = [];
        $config_common        = config("bas.adoption.application.common");
        $config_type          = config("bas.adoption.application.{$this->adoption_application->type}");
        $adoption_application = $this->adoption_application->toArray();

        // fix government_id_expires_at value, as it comes out of the database converted
        // from a date to a datetime, where it needs to stringified back to a date
        $adoption_application['government_id_expires_at'] = substr($adoption_application['government_id_expires_at'], 0, 10);

        foreach ($config_common as $config) {
            try {
                $value = $adoption_application[$config['id']];
                $this->validateIncomingData('common', $config['id'], $value);
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        $object_data = json_decode($adoption_application['object_data'], true);
        foreach ($config_type as $config) {
            try {
                // setting a default value because on non-required fields,
                // it's possible no "empty" value was submitted by the user.
                // If a user clicks into form fields without tabbing through,
                // they can skip the ones they don't intend to answer,
                // which means the field doesn't even exist in object_data,
                // thus causing an undefined index error at this spot.
                $default_value = $config['default_value'] ?? '';
                $value = $object_data[$config['id']] ?? $default_value;
                $this->validateIncomingData($this->adoption_application->type, $config['id'], $value);
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            throw new ArrayException($errors, 400);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function sendSubmitAdoptionApplicationEmail()
    {
        $email_recipient             = config("bas.contacts.application.email_recipients.{$this->adoption_application->type}");
        $to                          = config("bas.contacts.{$email_recipient}");
        $application_url             = config('app.url') . "/adoption-applications/{$this->adoption_application->token}";
        $application_url_no_protocol = config('app.app_domain_name') . "/adoption-applications/{$this->adoption_application->token}";
        $subject                     = config('bas.adoption.application.email_base_subject') . " - {$this->adoption_application->animal_name}";
        $params = [
            'application_details' => [
                [
                    'type' => $this->adoption_application->type,
                    'token' => $this->adoption_application->token,
                    'url' => $application_url,
                    'url_no_protocol' => $application_url_no_protocol,
                    'animal_name' => $this->adoption_application->animal_name,
                    'user_first_name' => $this->adoption_application->user->first_name,
                    'user_last_name' => $this->adoption_application->user->last_name,
                    'user_email' => $this->adoption_application->user->email,
                ],
            ],
        ];
        (new SendinBlue())->sendTransactionalEmail(
            'submit_adoption_application',
            $to['name']['first'],
            $to['name']['last'],
            $to['email'],
            $params,
            $subject
        );

        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function saveFieldCommon($field, $value)
    {
        $update_field_value = [
            $field => $value,
        ];
        $this->adoption_application->update($update_field_value);
        return Response::success($update_field_value);
    }

    /**
     * Get object data value
     * Json decode it
     * Add field & value
     * Json encode it
     * Save it back to object data
     *
     * @param $field
     * @param $value
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function saveFieldObjectData($field, $value)
    {
        $object_data
            = trim($this->adoption_application->object_data) === ''
            ? []
            : json_decode($this->adoption_application->object_data, true);

        $object_data[$field] = $value;
        $update_field_value  = [
            'object_data' => json_encode($object_data),
        ];
        $this->adoption_application->update($update_field_value);

        return Response::success(
            [
                $field => $value,
            ]
        );
    }

    /**
     * @param string $type
     * @param string $field
     * @param mixed $value
     * @return mixed
     * @throws Exception
     */
    protected function validateIncomingData($type, $field, $value)
    {
        return $this->validateValue(
            // these 2 chained together return back $config to pass directly into validateValue()
            $this
                ->validateIncomingDataStructure($type, $field)
                ->validateFieldIsInConfig($type, $field),
            $value
        );
    }

    /**
     * Note that since value is mixed and not always required,
     * and can therefore legitimately be false or empty string,
     * and this will come through $request->post() as null,
     * the "required" validation rule can't be globally applied to value,
     * which is why it's not being checked here.
     *
     * @param string $type
     * @param string $field
     * @return $this
     * @throws Exception
     */
    protected function validateIncomingDataStructure($type, $field)
    {
        $validationKeysToCheck = [
            'type'  => $type,
            'field' => $field,
        ];
        $validationRules = [
            'type'  => "required|in:common,{$this->adoption_application->type}",
            'field' => "required|string|min:4",
        ];

        $validation = validator($validationKeysToCheck, $validationRules);
        if ($validation->fails()) {
            throw new Exception("({$this->error_prefix}) {$validation->errors()}", 400);
        }

        return $this;
    }

    /**
     * @param string $type
     * @param string $field
     * @return object
     * @throws Exception
     */
    protected function validateFieldIsInConfig($type, $field)
    {
        $config = config("bas.adoption.application.{$type}");
        if (!array_key_exists($field, $config)) {
            throw new Exception("({$this->error_prefix}) Invalid field: {$field}", 400);
        }

        return (object) $config[$field];
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return mixed
     * @throws Exception
     */
    protected function validateValue($config, $value)
    {
        $method = "validateValue_{$config->validation}";
        if (!method_exists($this, $method)) {
            throw new Exception("({$this->error_prefix}) Invalid validation: {$config->validation}", 400);
        }

        return $this->{$method}($config, $value);
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return string
     * @throws Exception
     */
    protected function validateValue_text($config, $value)
    {
        return $this->basicValueValidationForTextLikeValues($config, $value);
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return string
     * @throws Exception
     */
    protected function validateValue_date($config, $value)
    {
        $value = $this->basicValueValidationForTextLikeValues($config, $value);
        $date  = strtotime($value);
        $min   = strtotime($config->min);
        $max   = strtotime($config->max);
        if ($date < $min || $date > $max) {
            throw new Exception("({$this->error_prefix}) {$config->label} must be between {$config->min} and {$config->max}", 400);
        }

        return $value;
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return string
     * @throws Exception
     */
    protected function validateValue_state($config, $value)
    {
        $value = $this->basicValueValidationForTextLikeValues($config, $value);
        if (!array_key_exists($value, Geography::states())) {
            throw new Exception("({$this->error_prefix}) Invalid state: {$value}", 400);
        }

        return $value;
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return string
     * @throws Exception
     */
    protected function validateValue_phone($config, $value)
    {
        $value = $this->basicValueValidationForTextLikeValues($config, $value);
        if ($value === '' && !$config->is_required) {
            return $value;
        }
        $value = PhoneNumber::factory($value);
        if (!$value->isValid()) {
            throw new Exception("({$this->error_prefix}) Invalid phone number: {$value}", 400);
        }

        return "{$value}";
    }

    /**
     * Note that numeric is being treated as a simple string
     * because an integer or a float can be treated as a string when being run through the validator
     * and when being saved to the database.
     *
     * @param object $config
     * @param mixed $value
     * @return string
     * @throws Exception
     */
    protected function validateValue_numeric($config, $value)
    {
        return $this->basicValueValidationForTextLikeValues($config, $value);
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return boolean
     * @throws Exception
     */
    protected function validateValue_checkbox($config, $value)
    {
        $this->runValidatorForValue($config, $value);

        if ($config->is_required && !$value) {
            $error = $config->invalid_feedback ?? 'This checkbox must be checked!';
            throw new Exception("({$this->error_prefix}) {$error}", 400);
        }

        return $value;
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return array
     * @throws Exception
     */
    protected function validateValue_checkbox_group($config, $value)
    {
        $this->runValidatorForValue($config, $value);

        if ($config->is_required && !$value) {
            $error = $config->invalid_feedback ?? 'You must select at least 1 answer!';
            throw new Exception("({$this->error_prefix}) {$error}", 400);
        }

        // if not required and nothing submitted, force to empty array for saving
        if (!$config->is_required && is_null($value)) {
            $value = [];
        }

        // mapping values to their integer values since the submit process turns them into strings
        return array_map(
            function($val) {
                return intval($val);
            }, $value
        );
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return string
     * @throws Exception
     */
    protected function basicValueValidationForTextLikeValues($config, $value)
    {
        $value = FunWithText::safeString($value);
        if ($value === '' && !$config->is_required) {
            return $value;
        }

        // create dummy string for validator with some common HTML encoded values changed back to their
        // raw characters, as the longer encoded strings are screwing with the character count
        $raw_value = str_replace('&#39;', "'", $value);
        $raw_value = str_replace('&#34;', '"', $raw_value);
        $raw_value = str_replace('&amp;', '&', $raw_value);

        $this->runValidatorForValue($config, $raw_value);

        return $value;
    }

    /**
     * @param object $config
     * @param mixed $value
     * @return $this
     * @throws Exception
     */
    protected function runValidatorForValue($config, $value)
    {
        $validationKeysToCheck = [
            $config->id => $value,
        ];
        $validationRules = [
            $config->id => $config->validator,
        ];

        $validation = validator($validationKeysToCheck, $validationRules);
        if ($validation->fails()) {
            throw new Exception("({$this->error_prefix}) {$validation->errors()}", 400);
        }

        return $this;
    }
}
