<?php

namespace App\Listeners;

use App\Events\DemoEvent;
use Supports\Facades\Interfaces\ShouldQueue;
use Supports\Facades\Mail;
use Supports\Facades\Traits\Dispatchable;

class Demo1 implements ShouldQueue
{
    use Dispatchable;

    public function handle(DemoEvent $event)
    {
        (new Mail($event->data))->send();
    }
}
