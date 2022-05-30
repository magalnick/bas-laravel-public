<?php

namespace App\Domain\SendMail;

use App\Domain\SendMail\Contracts\SendMail as SendMailContract;
use App\Utilities\FunWithText;
use Exception;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailTo;
use GuzzleHttp\Client as GuzzleClient;
use Log;

class SendinBlue extends SendMail implements SendMailContract
{
    protected $templates;
    protected $apikey;
    protected $config;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return $this|SendMail
     */
    public function init()
    {
        $this->templates = config('services.sendinblue.templates');
        $this->apikey    = config('services.sendinblue.key');
        $this->config    = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->apikey);
        $this->config    = Configuration::getDefaultConfiguration()->setApiKey('partner-key', $this->apikey);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param string $template
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param array $params
     * @param string $subject_override
     * @return mixed
     * @throws Exception
     */
    public function sendTransactionalEmail($template, $first_name, $last_name, $email, $params = [], $subject_override = '')
    {
        list($template, $first_name, $last_name, $email) = $this->validateTransactionalEmailArguments($template, $first_name, $last_name, $email);
        $params['recipients'] = [
            [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
            ],
        ];

        $to = [
            (new SendSmtpEmailTo())
                ->setEmail($email)
                ->setName("{$first_name} {$last_name}"),
        ];

        // params need to be sent as a JSON object, so here goes:
        $params = json_decode(json_encode($params));

        $template_id = intval($this->templates[$template]['id']);
        $sendSmtpEmail = (new SendSmtpEmail())
            ->setTo($to)
            ->setTemplateId($template_id)
            ->setParams($params);

        if (FunWithText::safeString($subject_override) !== '') {
            $sendSmtpEmail->setSubject(FunWithText::safeString($subject_override));
        }

        Log::info('Object SendSmtpEmail() that will be passed to sendTransacEmail()', ['SendSmtpEmail' => $sendSmtpEmail]);
        $apiInstance = $this->getTransactionalEmailsApiInstance();

        $createSmtpEmail = $apiInstance->sendTransacEmail($sendSmtpEmail);
        Log::info('createSmtpEmail->getMessageId()', ['message_id' => $createSmtpEmail->getMessageId()]);
        return [
            'message_id' => $createSmtpEmail->getMessageId(),
        ];
    }

    /**
     * @param $template
     * @param $first_name
     * @param $last_name
     * @param $email
     * @return array
     * @throws Exception
     */
    protected function validateTransactionalEmailArguments($template, $first_name, $last_name, $email)
    {
        return [
            $this->validateTransactionalEmailTemplate($template),
            $this->validateTransactionalEmailFirstName($first_name),
            $this->validateTransactionalEmailLastName($last_name),
            $this->validateTransactionalEmailEmail($email),
        ];
    }

    /**
     * @param $template
     * @return mixed|string
     * @throws Exception
     */
    protected function validateTransactionalEmailTemplate($template)
    {
        $template = filter_var($template, FILTER_SANITIZE_STRING);
        if (!is_string($template)) {
            throw new Exception('Email template must be a string', 400);
        }
        $template = trim($template);
        if ($template === '') {
            throw new Exception('No email template specified', 400);
        }
        if (!array_key_exists($template, $this->templates)) {
            throw new Exception("Invalid email template: {$template}", 400);
        }

        return $template;
    }

    /**
     * @param $first_name
     * @return string
     * @throws Exception
     */
    protected function validateTransactionalEmailFirstName($first_name)
    {
        $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
        if (!is_string($first_name)) {
            throw new Exception('First name must be a string', 400);
        }
        $first_name = trim($first_name);
        if ($first_name === '') {
            throw new Exception('No first name specified', 400);
        }

        return $first_name;
    }

    /**
     * @param $last_name
     * @return string
     * @throws Exception
     */
    protected function validateTransactionalEmailLastName($last_name)
    {
        $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
        if (!is_string($last_name)) {
            throw new Exception('Last name must be a string', 400);
        }
        $last_name = trim($last_name);
        if ($last_name === '') {
            throw new Exception('No last name specified', 400);
        }

        return $last_name;
    }

    /**
     * @param $email
     * @return string
     * @throws Exception
     */
    protected function validateTransactionalEmailEmail($email)
    {
        if (!is_string($email)) {
            throw new Exception('Email must be a string', 400);
        }
        $email = trim($email);
        if ($email === '') {
            throw new Exception('No email specified', 400);
        }

        $filtered_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ($filtered_email !== $email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email: {$email}", 400);
        }

        return $email;
    }

    /**
     * @return array
     */
    public function getSmtpTemplates()
    {
        //$templateStatus = true;
        //$limit = 50;
        //$offset = 0;
        //$sort = "desc";
        // Note: passing these values throws a 400 error because the API expects template status to be a boolean,
        // but the composer library translates the boolean to 1|0 for the GET call to the API.
        // That's a bug somewhere out of my control, and leaving the parameters empty works.
        return array_map(
            function ($getSmtpTemplateOverview) {
                return [
                    'id'         => $getSmtpTemplateOverview->getId(),
                    'name'       => $getSmtpTemplateOverview->getName(),
                    'subject'    => $getSmtpTemplateOverview->getSubject(),
                    'isActive'   => $getSmtpTemplateOverview->getIsActive(),
                    'testSent'   => $getSmtpTemplateOverview->getTestSent(),
                    'replyTo'    => $getSmtpTemplateOverview->getReplyTo(),
                    'tag'        => $getSmtpTemplateOverview->getTag(),
                    'createdAt'  => $getSmtpTemplateOverview->getCreatedAt(),
                    'modifiedAt' => $getSmtpTemplateOverview->getModifiedAt(),
                ];
            },
            ($this->getTransactionalEmailsApiInstance())->getSmtpTemplates()->getTemplates()
        );
    }

    /**
     * @return mixed
     */
    public function getLists()
    {
        return ($this->getListsApiInstance())->getLists();
    }

    /**
     * @return mixed
     */
    protected function getTransactionalEmailsApiInstance()
    {
        return $this->getSendinBlueApiInstance('TransactionalEmailsApi');
    }

    /**
     * @return mixed
     */
    protected function getListsApiInstance()
    {
        return $this->getSendinBlueApiInstance('ListsApi');
    }

    /**
     * @param $sendin_blue_api_service
     * @return mixed
     */
    protected function getSendinBlueApiInstance($sendin_blue_api_service)
    {
        $class_name = "SendinBlue\\Client\\Api\\{$sendin_blue_api_service}";
        return new $class_name(
            new GuzzleClient(),
            $this->config
        );
    }
}
