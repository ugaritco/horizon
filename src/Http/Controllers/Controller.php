<?php

namespace Ugarit\Horizon\Http\Controllers;

use Heritage\Routing\Controller as BaseController;
use Ugarit\Horizon\Http\Middleware\Authenticate;

class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }
}
