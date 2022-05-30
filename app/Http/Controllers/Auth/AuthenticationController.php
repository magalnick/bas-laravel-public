<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Http\Response;
use App\Models\MvcBusinessLogic\Authentication\GetStarted;

class AuthenticationController extends Controller
{
    /**
     * AuthenticationController constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // 2 hours - 60 * 120
        // 30 days - 60 * 60 * 24 * 30
        // TODO - change back to 2 hour default, and give the user an option to select 30 days
        $future_time = strval(time() + 60 * 60 * 24 * 30);
        $user        = $request->user->updatePassword($future_time);

        return Response::success(
            [
                config('bas.auth.local_storage.username') => $user->token,
                config('bas.auth.local_storage.password') => $future_time,
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getStarted(Request $request)
    {
        return (new GetStarted($request))->init();
    }
}
