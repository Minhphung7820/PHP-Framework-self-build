<?php

namespace Providers;

use Core\Router;

class RouteServiceProvider extends Router implements BaseServiceProvider
{
    public function boot()
    {
        $this->register('api/user.php');
        $this->register('api/product.php');
        $this->register('web.php');
        $this->runRoutes();
    }
}
