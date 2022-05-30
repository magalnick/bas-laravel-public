<?php

namespace App\Models\MvcBusinessLogic\Authentication;

use Illuminate\Http\Request;
use App\Domain\SendMail\SendinBlue;
use ReCaptcha\ReCaptcha;
use App\Utilities\FunWithText;
use App\Http\Response;
use Exception;
use App\Models\MvcBusinessLogic\AbstractModel;
use App\Models\Database\User;
use App\ValueObjects\UserLoginToken;
use Crypt;
use Log;

class GetStarted extends AbstractModel implements AuthenticationContract
{
    protected $user;
    protected $password_token;
    protected $future_time;
    protected $first_name;
    protected $last_name;
    protected $email;

    // substr(md5('GetStarted'), 0, 6)
    private $error_prefix = '6ca8fb';

    /**
     * GetStarted constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $random_min           = intval(config('bas.auth.login_token_range.min'));
        $random_max           = intval(config('bas.auth.login_token_range.max'));
        $this->user           = null;
        $this->password_token = strval(rand($random_min, $random_max));
        $this->future_time    = strval(time() + 60 * 30);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function init()
    {
        try {
            $this
                ->validateFirstLastEmail()
                ->setupUserObject()
                ->sendLoginTokenEmail();

            return Response::success(
                [
                    config('bas.auth.local_storage.user_hash') => Crypt::encrypt(
                        strval(
                            UserLoginToken::factory([
                                $this->user->token,
                                $this->future_time,
                                //$this->password_token,
                            ])
                        )
                    ),
                    config('bas.auth.local_storage.email') => $this->user->email,
                    //'token' => $this->password_token,
                ]
            );
        } catch (Exception $e) {
            return Response::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function validateFirstLastEmail()
    {
        $this->first_name = FunWithText::safeString(
            $this->request->get('first_name')
        );
        $this->last_name = FunWithText::safeString(
            $this->request->get('last_name')
        );
        $this->email = FunWithText::safeEmail(
            $this->request->get('email')
        );
        if ($this->first_name === '') {
            throw new Exception("({$this->error_prefix}) First name required", 400);
        }
        if ($this->last_name === '') {
            throw new Exception("({$this->error_prefix}) Last name required", 400);
        }
        if ($this->email === '') {
            throw new Exception("({$this->error_prefix}) Email required", 400);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function setupUserObject()
    {
        $this->user = (new User())->findByEmail($this->email);
        if (is_null($this->user)) {
            $this->user = (new User())->add($this->first_name, $this->last_name, $this->email, $this->password_token);
            return $this;
        }

        $this->user = $this->user->updatePassword($this->password_token);
        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function sendLoginTokenEmail()
    {
        $params = [
            'tokens' => [
                [
                    'code' => $this->password_token,
                ],
            ],
        ];
        (new SendinBlue())->sendTransactionalEmail(
            'login_token',
            $this->first_name,
            $this->last_name,
            $this->email,
            $params
        );

        return $this;
    }
}
