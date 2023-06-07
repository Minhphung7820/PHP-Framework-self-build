<?php

namespace Bootstrap;

use App\Providers\HelperServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Providers\SessionHandlerServiceProvider;

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
