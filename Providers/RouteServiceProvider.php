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
        $this->loadRoute('api.user', router('api.user'), config('kernel.middlewares'));
        $this->loadRoute('api.product', router('api.product'), config('kernel.middlewares'));
    }
    public function loadRouteWeb()
    {
        $this->loadRoute('web', router('web'), config('kernel.middlewares'));
    }
}
