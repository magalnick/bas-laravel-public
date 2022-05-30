<?php

namespace App\Models\MvcBusinessLogic\AdoptionApplication;

use App\Http\Response;
use App\Models\MvcBusinessLogic\AbstractModel;
use Illuminate\Http\Request;
use App\Models\Database\AdoptionApplication;

class AdoptionApplicationsListManager extends AbstractModel
{
    private static $instance = null;

    // substr(md5('AdoptionApplicationsListManager'), 0, 6)
    private $error_prefix = 'a4d973';

    private $application_types;

    /**
     * @param Request $request
     * @return AdoptionApplicationsListManager
     */
    public static function singleton(Request $request)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($request);
        }

        return self::$instance;
    }

    /**
     * AdoptionApplicationsListManager constructor.
     * @param Request $request
     */
    private function __construct(Request $request)
    {
        parent::__construct($request);
        $this->application_types = AdoptionApplication::applicationTypes();
    }

    /**
     * @return array
     */
    public function getApplicationsForLoggedInUser()
    {
        // build up the returnable data as all applications for a user
        // sorted by update date, descending
        // mapped for friendly display like dates and setting a "status" flag for the display to use
        return $this->request->user->adoptionApplications
            ->sort(function($a, $b) {
                switch (true) {
                    case $a->updated_at > $b->updated_at:
                        return -1;
                    case $a->updated_at < $b->updated_at:
                        return 1;
                    default:
                        return 0;
                }
            })
            ->values()
            ->map(function($app) {
                $app->created = date('Y-m-d H:i', $app->created_at);
                $app->updated = date('Y-m-d H:i', $app->updated_at);
                $app->status  = $app->status();

                if ($app->submitted_at > 100000) {
                    $app->submitted = date('Y-m-d H:i', $app->submitted_at);
                }
                if ($app->archived_at > 100000) {
                    $app->archived = date('Y-m-d H:i', $app->archived_at);
                }

                return $app;
            })
            ->all();
    }

    /**
     * @return bool
     */
    public function loggedInUserIsAnyAdoptionApplicationAdmin()
    {
        $types = $this->applicationTypesForThisLoggedInUserToAdminister();
        return empty($types) ? false : true;
    }

    /**
     * @return array
     */
    public function getApplicationsForAdminUser()
    {
        $types = $this->applicationTypesForThisLoggedInUserToAdminister();
        if (empty($types)) {
            return [];
        }

        return (new AdoptionApplication())
            ->submittedApplications($types)
            ->values()
            ->map(function($app) {
                $user = $app->user;

                // clear out object_data to save on bandwidth
                $app->object_data = null;
                $app->applicant   = "{$user->first_name} {$user->last_name}";
                $app->submitted   = date('Y-m-d H:i', $app->submitted_at);
                return $app;
            })
            ->all();
    }

    /**
     * @return array
     */
    protected function applicationTypesForThisLoggedInUserToAdminister()
    {
        $types = [];
        foreach ($this->application_types as $type) {
            if ($this->request->user->isAdoptionApplicationAdministrator($type)) {
                $types[] = $type;
            }
        }
        return $types;
    }
}
