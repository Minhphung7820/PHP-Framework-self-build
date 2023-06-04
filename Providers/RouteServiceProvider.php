<?php

namespace Providers;

use Core\Router;

class RouteServiceProvider extends Router implements BaseServiceProvider
{
    public function boot()
    {
        $this->register(router('api.user'));
        $this->register(router('api.product'));
        $this->register(router('web'));
        $this->runRoutes();
    }
}
