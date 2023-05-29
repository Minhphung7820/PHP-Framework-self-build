<?php

namespace Core;

use Providers\HelperServiceProvider;

class Bootstrap
{
    protected $providers = [
        HelperServiceProvider::class
    ];
    public function __construct()
    {
        foreach ($this->providers as $provider) {
            $runProvider = new $provider();
            $runProvider->boot();
        }
    }
}
