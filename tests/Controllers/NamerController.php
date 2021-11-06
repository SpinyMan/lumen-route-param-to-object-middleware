<?php

namespace SpinyMan\LumenRouteParamToObject\Tests\Controllers;

use Laravel\Lumen\Http\Request;
use Laravel\Lumen\Routing\Controller;
use SpinyMan\LumenRouteParamToObject\Tests\Entities\Namer;

class NamerController extends Controller
{
    public function index(Request $request, Namer $namer)
    {
        return $namer->run();
    }
}
