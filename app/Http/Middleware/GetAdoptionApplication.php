<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Response;
use App\Models\Database\User;
use App\Models\Database\AdoptionApplication;
use App\Utilities\FunWithText;
use Exception;

class GetAdoptionApplication
{
    // substr(md5('GetAdoptionApplication'), 0, 6)
    private $error_prefix = '456aff';

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
            if (!FunWithText::isUuid($request->route('token'))) {
                throw new Exception("({$this->error_prefix}) Invalid application token", 400);
            }
            $token = trim($request->route('token'));

            $user = $request->user ?? null;
            if (is_null($user)) {
                throw new Exception("({$this->error_prefix}) User has not been authenticated", 400);
            }

            // first get the application for the specified token
            // then check that the user is either the applicant or an administrator
            $adoption_application = AdoptionApplication::where('token', $token)->first();
            if (!$adoption_application) {
                throw new Exception("404 - Not Found", 404);
            }

            $is_adoption_application_administrator = $user->isAdoptionApplicationAdministrator($adoption_application->type);
            if (!$is_adoption_application_administrator && $user->id !== $adoption_application->user_id) {
                throw new Exception("404 - Not Found", 404);
            }

            $request->merge(
                [
                    'application_token'    => $token,
                    'adoption_application' => $adoption_application,
                    'is_application_admin' => $is_adoption_application_administrator,
                ]
            );

            return $next($request);
        } catch (Exception $e) {
            return Response::error($e->getMessage(), $e->getCode());
        }
    }
}
