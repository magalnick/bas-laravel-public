<?php

namespace App\ValueObjects;

use App\Utilities\FunWithText;
use Exception;

class UserLoginToken extends AbstractValueObject implements ValueObject
{
    protected $user_token;
    protected $expires_at;
    protected $password_token;

    // substr(md5('UserLoginToken'), 0, 6)
    private $error_prefix = '4c6916';

    /**
     * StorageFile constructor.
     * @param $data
     */
    protected function __construct($data)
    {
        parent::__construct($data);

        $this->validateData($data);
    }

    /**
     * @param $data
     * @throws Exception
     */
    protected function validateData($data)
    {
        if (!is_array($data) || empty($data)) {
            throw new Exception("({$this->error_prefix}) No data to set", 500);
        }
        if (sizeof($data) !== 2 && sizeof($data) !== 3) {
            throw new Exception("({$this->error_prefix}) Wrong amount of data to set", 500);
        }

        $user_token     = array_shift($data);
        $expires_at     = array_shift($data);
        $password_token = array_shift($data);

        $this->user_token     = $this->userToken($user_token);
        $this->expires_at     = $this->expiresAt($expires_at);
        $this->password_token = $this->passwordToken($password_token);
    }

    /**
     * @param string $user_token
     * @return string
     * @throws Exception
     */
    protected function userToken(string $user_token)
    {
        $user_token = FunWithText::safeString($user_token);

        if (!FunWithText::isUuid($user_token)) {
            throw new Exception("({$this->error_prefix}) Invalid user token: {$user_token}", 500);
        }

        return $user_token;
    }

    /**
     * @param $expires_at
     * @return int
     * @throws Exception
     */
    protected function expiresAt($expires_at)
    {
        if (!is_numeric($expires_at)) {
            throw new Exception("({$this->error_prefix}) Invalid expiration, expected UNIX timestamp", 500);
        }
        if (intval($expires_at) < time()) {
            throw new Exception("({$this->error_prefix}) Time has already expired", 500);
        }

        return intval($expires_at);
    }

    /**
     * @param $password_token
     * @return int|null
     * @throws Exception
     */
    protected function passwordToken($password_token)
    {
        $min  = config('bas.auth.login_token_range.min');
        $max  = config('bas.auth.login_token_range.max');
        $size = config('bas.auth.login_token_range.size');

        if (!$password_token) {
            return null;
        }
        if (
            !is_numeric($password_token)
            || intval($password_token) < $min
            || intval($password_token) > $max
        )
        {
            throw new Exception("({$this->error_prefix}) Invalid password token, expected {$size} digit number", 500);
        }

        return intval($password_token);
    }

    /**
     * @param $password_token
     * @return int|null
     * @throws Exception
     */
    public function validatePasswordToken($password_token)
    {
        // doing as a try catch because the public call should return a 400 instead of a 500 on failure
        try {
            $password_token = $this->passwordToken($password_token);
            if (is_null($this->password_token) || is_null($password_token)) {
                return $password_token;
            }
            if ($this->password_token !== $password_token) {
                return null;
            }

            return $password_token;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 400);
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        switch ($name) {
            case 'user_token':
            case 'token':
                return $this->user_token;
            case 'expires_at':
                return $this->expires_at;
            case 'password_token':
                return $this->password_token;
            default:
                throw new Exception("({$this->error_prefix}) Invalid property: {$name}", 500);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize($this);
    }
}
