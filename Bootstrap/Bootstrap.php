<?php

namespace Bootstrap;

use Providers\AppServiceProvider;
use Providers\HelperServiceProvider;
use Providers\RouteServiceProvider;

class Bootstrap
{
    protected $providersRegisted = [
        HelperServiceProvider::class,
        RouteServiceProvider::class,
        AppServiceProvider::class,
    ];
    public function __construct()
    {
        foreach ($this->providersRegisted as $provider) {
            $runProvider = new $provider();
            $runProvider->boot();
        }
    }
}
