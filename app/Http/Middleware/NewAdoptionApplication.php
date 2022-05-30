<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Response;
use App\Models\Database\User;
use App\Models\Database\AdoptionApplication;
use App\Utilities\FunWithText;
use Exception;

class NewAdoptionApplication
{
    // substr(md5('NewAdoptionApplication'), 0, 6)
    private $error_prefix = 'fbfacf';

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
            $user = $request->user ?? null;
            if (is_null($user)) {
                throw new Exception("({$this->error_prefix}) User has not been authenticated", 400);
            }

            $application_types = AdoptionApplication::applicationTypes();

            $application_type = FunWithText::safeString(
                $request->post('application_type')
            );
            if ($application_type === '') {
                throw new Exception("({$this->error_prefix}) No application type specified", 400);
            }
            if (!in_array($application_type, $application_types)) {
                throw new Exception("({$this->error_prefix}) Invalid application type: {$application_type}", 400);
            }

            // if there is an "empty" application in the database, just return it back
            $empty_application = (new AdoptionApplication())->emptyApplicationForUserByType($user, $application_type);
            if ($empty_application) {
                return Response::success([
                    'adoption_application' => [
                        'token' => $empty_application->token,
                        'type'  => $empty_application->type,
                    ],
                ]);
            }

            $request->merge(
                [
                    'application_type'  => $application_type,
                ]
            );

            return $next($request);
        } catch (Exception $e) {
            return Response::error($e->getMessage(), $e->getCode());
        }
    }
}
