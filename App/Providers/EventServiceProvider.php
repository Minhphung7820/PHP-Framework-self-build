<?php

namespace App\Providers;

use App\Events\AfterRegisted;
use App\Listeners\SendNotify;

class EventServiceProvider implements BaseServiceProvider
{
    const LISTENER_MAPPING = [
        \App\Events\AfterRegisted::class => [
            \App\Listeners\SendNotify::class
        ]
    ];
    public function register()
    {
    }
    public function boot()
    {
    }
}
