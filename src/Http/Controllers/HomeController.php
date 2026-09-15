<?php

namespace Ugarit\Horizon\Http\Controllers;

use Heritage\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Heritage\Contracts\View\Factory|\Heritage\View\View
     */
    public function index()
    {
        return view('horizon::layout', [
            'isDownForMaintenance' => App::isDownForMaintenance(),
        ]);
    }
}
