<?php

namespace Bootstrap;

use Providers\HelperServiceProvider;
use Providers\RouteServiceProvider;

class Bootstrap
{
    protected $providersRegisted = [
        HelperServiceProvider::class,
        RouteServiceProvider::class,
    ];
    public function __construct()
    {
        foreach ($this->providersRegisted as $provider) {
            $runProvider = new $provider();
            $runProvider->boot();
        }
    }
}
