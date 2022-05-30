<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Response;
use ReCaptcha\ReCaptcha;
use App\Utilities\FunWithText;

class ValidateRecaptcha
{
    // substr(md5('ValidateRecaptcha'), 0, 6)
    private $error_prefix = '8b9f40';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $grecaptcha_response = FunWithText::safeString(
            $request->get('grecaptcha_response')
        );

        $recaptcha = (new ReCaptcha(
            config('services.google.recaptcha.secret_key')
        ))->verify($grecaptcha_response);
        if (!$recaptcha->isSuccess()) {
            $errors = array_map(
                function($error_code) {
                    return config('services.google.recaptcha.error_codes')[$error_code];
                }, $recaptcha->getErrorCodes()
            );
            return Response::error("({$this->error_prefix}) $errors[0]", 400);
        }

        return $next($request);
    }
}
