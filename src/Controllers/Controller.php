<?php

namespace gitkv\Uniteller\Controllers;

//laravel
if (class_exists(\Illuminate\Routing\Controller::class)) {
    class Controller extends \Illuminate\Routing\Controller {
        use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
        //...
    }
}

//lumen
if (class_exists(\Laravel\Lumen\Routing\Controller::class)) {
    class Controller extends \Laravel\Lumen\Routing\Controller {
        //...
    }
}