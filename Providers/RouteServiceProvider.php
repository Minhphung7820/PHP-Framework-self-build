<?php

namespace Providers;

use Core\Router;

class RouteServiceProvider extends Router implements BaseServiceProvider
{
    public function boot()
    {
        $this->loadRouteApi();
        $this->loadRouteWeb();
        $this->notFound();
    }
    public function loadRouteApi()
    {
        $this->loadRoutes('api.user', router('api.user'));
        $this->loadRoutes('api.product', router('api.product'));
    }
    public function loadRouteWeb()
    {
        $this->loadRoutes('web', router('web'), [
            // \Http\Middlewares\CheckLogin::class
        ]);
    }
}
