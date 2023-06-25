<?php

namespace App\Listeners;

use App\Events\AfterRegisted;
use Supports\Facades\Interfaces\ShouldQueue;
use Supports\Facades\Traits\Dispatchable;
use Supports\Facades\Mail;

class SendNotify implements ShouldQueue
{
    use Dispatchable;
    public function handle(AfterRegisted $event)
    {
        (new Mail($event->data))->send();
    }
}
