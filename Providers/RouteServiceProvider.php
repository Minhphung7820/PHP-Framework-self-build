<?php

namespace Providers;

use Core\Router;

class RouteServiceProvider extends Router implements BaseServiceProvider
{
    public function boot()
    {
        $this->loadRouteApi();
        $this->loadRouteWeb();
    }
    public function loadRouteApi()
    {
        $this->loadRouteFrom(router('api.user'), config('kernel.middlewares'));
        $this->loadRouteFrom(router('api.product'), config('kernel.middlewares'));
    }
    public function loadRouteWeb()
    {
        $this->loadRouteFrom(router('web'), config('kernel.middlewares'));
    }
}
