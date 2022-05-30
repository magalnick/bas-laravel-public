<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Response;
use App\Utilities\FunWithText;
use App\ValueObjects\UserLoginToken;
use App\Models\Database\User;
use Crypt;
use Exception;

class LoginBas
{
    // substr(md5('LoginBas'), 0, 6)
    private $error_prefix = '9db73d';

    // substr(md5('You screwed with the UserLoginToken'), 0, 6)
    private $screwed_with_user_login_token = '239a9d';

    // substr(md5('Invalid password token'), 0, 6)
    private $invalid_password_token = 'a5c199';

    // substr(md5('mismatched credentials in database'), 0, 6)
    private $mismatched_credentials_in_database = '2aeda1';

    private $generic_bad_login_error = 'Your credentials do not match our records';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user_hash      = FunWithText::safeString($request->getUser());
            $password_token = FunWithText::safeString($request->getPassword());
            $time           = time();

            if ($user_hash === '' || $password_token === '') {
                throw new Exception("({$this->error_prefix}) Missing user and/or password", 400);
            }

            $user_login_token = $this->validateUserHash($user_hash);
            $password_token   = $this->validatePasswordToken($user_login_token, $password_token);

            if ($user_login_token->expires_at < $time) {
                throw new Exception("({$this->error_prefix}) The login token has expired", 401);
            }

            $user = (new User())->authenticateByToken($user_login_token->user_token, (string) $password_token);
            if (is_null($user)) {
                throw new Exception("({$this->error_prefix}-{$this->mismatched_credentials_in_database}) {$this->generic_bad_login_error}", 401);
            }

            $request->merge(
                [
                    'user'  => $user,
                ]
            );
            return $next($request);
        } catch (Exception $e) {
            return Response::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $user_hash
     * @return mixed
     * @throws Exception
     */
    private function validateUserHash($user_hash)
    {
        $user_login_token = unserialize(
            Crypt::decrypt($user_hash),
            [
                'allowed_classes' => [
                    'App\ValueObjects\UserLoginToken'
                ]
            ]
        );
        if (!$user_login_token || get_class($user_login_token) !== 'App\ValueObjects\UserLoginToken') {
            throw new Exception("({$this->error_prefix}-{$this->screwed_with_user_login_token}) {$this->generic_bad_login_error}", 401);
        }

        return $user_login_token;
    }

    /**
     * @param UserLoginToken $user_login_token
     * @param $password_token
     * @return int|null
     * @throws Exception
     */
    private function validatePasswordToken(UserLoginToken $user_login_token, $password_token)
    {
        $password_token = $user_login_token->validatePasswordToken($password_token);
        if (is_null($password_token)) {
            throw new Exception("({$this->error_prefix}-{$this->invalid_password_token}) {$this->generic_bad_login_error}", 401);
        }
        return $password_token;
    }
}
