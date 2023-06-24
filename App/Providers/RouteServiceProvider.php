<?php

namespace App\Providers;

use Core\Router;

class RouteServiceProvider extends Router implements BaseServiceProvider
{
    public function register()
    {
    }
    public function boot()
    {
        $this->loadRouteFrom('api/user.php');
        $this->loadRouteFrom('api/product.php');
        $this->loadRouteFrom('web.php');
        $this->loadRouteFrom('auth/auth.php');
        $this->runRoutes();
    }
}
