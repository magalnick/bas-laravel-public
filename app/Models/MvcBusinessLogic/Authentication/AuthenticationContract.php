<?php

namespace App\Models\MvcBusinessLogic\Authentication;

use Illuminate\Http\Request;

interface AuthenticationContract
{
    public function __construct(Request $request);
    public function init();
}
