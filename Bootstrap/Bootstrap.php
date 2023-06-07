<?php

namespace Bootstrap;

use Providers\HelperServiceProvider;
use Providers\RouteServiceProvider;
use Providers\SessionHandlerServiceProvider;

class Bootstrap
{
    protected $providersRegisted = [
        SessionHandlerServiceProvider::class,
        HelperServiceProvider::class,
        RouteServiceProvider::class,
    ];
    public function run()
    {
        foreach ($this->providersRegisted as $provider) {
            $runProvider = new $provider();
            $runProvider->boot();
        }
    }
}
