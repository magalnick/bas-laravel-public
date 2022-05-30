<?php

namespace App\Models\MvcBusinessLogic;

use Illuminate\Http\Request;

abstract class AbstractModel
{
    protected $request;

    /**
     * GetStarted constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
