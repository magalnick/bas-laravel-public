<?php

namespace App\Http\Controllers;

use App\Utilities\FunWithText;
use App\Utilities\Geography;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;
use App\Models\Database\AdoptionApplication;
use App\Models\MvcBusinessLogic\AdoptionApplication\AdoptionApplicationManager;
use App\Models\MvcBusinessLogic\AdoptionApplication\AdoptionApplicationsListManager;
use App\Models\MvcBusinessLogic\AdoptionApplication\LegacyAdoptionApplication;
use App\Http\Response;
use Exception;
use App\Exceptions\ArrayException;
use Log;

class AdoptionApplicationsController extends Controller
{
    // substr(md5('AdoptionApplicationsController'), 0, 6)
    private $error_prefix = '529595';

    private $application_types;

    /**
     * AdoptionApplicationsController constructor.
     */
    public function __construct()
    {
        $this->application_types = AdoptionApplication::applicationTypes();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getApplication(Request $request)
    {
        try {
            // break the data out of eloquent mode so it can be easily manipulated if needed
            $adoption_application = $request->adoption_application->toArray();
            $adoption_application['government_id_expires_at']
                = $request->adoption_application->government_id_expires_at->getTimestamp() < 1
                ? ''
                : $request->adoption_application->government_id_expires_at->format('Y-m-d');

            $object_data = (object) [];
            if ($adoption_application['object_data'] !== '') {
                $object_data = json_decode($adoption_application['object_data']);
            }
            $adoption_application['object_data'] = $object_data;

            $adoption_application_user = $request->adoption_application->user->toArray();
            $adoption_application_user['name'] = "{$adoption_application_user['first_name']} {$adoption_application_user['last_name']}";

            return Response::success([
                'adoption_application'        => $adoption_application,
                'adoption_application_user'   => $adoption_application_user,
                'adoption_application_status' => $request->adoption_application->status(),
                'is_editable'                 => $request->adoption_application->status() === 'Active',
                'is_application_admin'        => $request->is_application_admin,
            ]);
        } catch (Exception $e) {
            return Response::error(
                "({$this->error_prefix}) {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function saveApplicationField(Request $request)
    {
        try {
            return AdoptionApplicationManager::singleton($request->adoption_application, $request)->saveField();
        } catch (Exception $e) {
            return Response::error(
                "({$this->error_prefix}) {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function setApplicationStatus(Request $request)
    {
        try {
            return AdoptionApplicationManager::singleton($request->adoption_application, $request)
                ->setApplicationStatus(
                    FunWithText::safeString($request->post('action'))
                );
        } catch (Exception $e) {
            return Response::error(
                "({$this->error_prefix}) {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getApplications(Request $request)
    {
        try {
            $data = [
                'adoption_applications' => AdoptionApplicationsListManager::singleton($request)->getApplicationsForLoggedInUser(),
                'is_admin'              => false,
            ];

            if (
                AdoptionApplicationsListManager::singleton($request)
                    ->loggedInUserIsAnyAdoptionApplicationAdmin()
            ) {
                $data['is_admin']                    = true;
                $data['adoption_applications_admin'] = AdoptionApplicationsListManager::singleton($request)->getApplicationsForAdminUser();
            }

            return Response::success($data);
        } catch (Exception $e) {
            return Response::error(
                "({$this->error_prefix}) {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * Add a new adoption application of type $application_type for the authenticated user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $adoption_application = (new AdoptionApplication())->add($request->user, $request->application_type);
            return Response::success([
                'adoption_application' => [
                    'token' => $adoption_application->token,
                ],
            ]);
        } catch (Exception $e) {
            return Response::error(
                "({$this->error_prefix}) {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view(Request $request)
    {
        // default to dog, change to other valid type if specified in query string
        $application_type = 'dog';
        if (
            in_array(
                FunWithText::safeString(
                    $request->get('type')
                ), AdoptionApplication::applicationTypes()
            )
        ) {
            $application_type = FunWithText::safeString(
                $request->get('type')
            );
        }

        return view(config('bas.view.main_site_blade_template'), [
            'page'                    => 'adoption-applications',
            'js'                      => 'adoption-applications',
            'application_type'        => $application_type,
            'api_application_prefix'  => 'adoption-applications',
            'authentication_required' => true,
        ]);
    }

    /**
     * @param Request $request
     * @param string $token
     * @param bool $print
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewApplication(Request $request, $token, $print = false)
    {
        if (!FunWithText::isUuid($token)) {
            return view(config('bas.view.error_blade_template'), [
                'page'   => 'adoption-application-by-token',
                'errors' => ['Invalid application token'],
            ]);
        }

        $token = trim($token);

        // get the application, regardless of who owns it, so the type can be put into the DOM
        // this will help with the overall page load
        $adoption_application = AdoptionApplication::where('token', $token)->first();
        $application_type     = $adoption_application ? $adoption_application->type : '';
        $application_status   = $adoption_application ? $adoption_application->status() : '';

        $lists = config('bas.adoption.application.lists');
        $lists['states'] = Geography::states();

        return view(config('bas.view.main_site_blade_template'), [
            'page'                        => 'adoption-application-by-token',
            'js'                          => 'adoption-application-by-token',
            'api_application_prefix'      => 'adoption-applications',
            'application_token'           => $token,
            'application_type'            => $application_type,
            'application_status'          => $application_status,
            'is_editable'                 => $application_status === 'Active',
            'application_config_user'     => config('bas.adoption.application.user'),
            'application_config_common'   => config('bas.adoption.application.common'),
            'application_config_for_type' => config("bas.adoption.application.{$application_type}"),
            'authentication_required'     => true,
            'states'                      => Geography::states(),
            'lists'                       => $lists,
            'print'                       => $print,
        ]);
    }

    /**
     * @param Request $request
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function printApplication(Request $request, $token)
    {
        return $this->viewApplication($request, $token, true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function legacy(Request $request)
    {
        $legacy_adoption_application = new LegacyAdoptionApplication($request);
        return view(config('bas.view.main_site_blade_template'), [
            'page'        => 'adoption-application-legacy',
            'application' => $legacy_adoption_application,
        ]);
    }
}
