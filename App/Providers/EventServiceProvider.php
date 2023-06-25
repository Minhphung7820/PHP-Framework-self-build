<?php

namespace App\Providers;

use App\Events\DemoEvent;
use App\Listeners\Demo1;
use App\Listeners\Demo2;

class EventServiceProvider implements BaseServiceProvider
{
    const LISTENER_MAPPING = [
        DemoEvent::class => [
            Demo1::class,
            Demo2::class
        ]
    ];
    public function register()
    {
    }
    public function boot()
    {
    }
}
