<?php

namespace App\Listeners;

use App\Events\AfterRegisted;

class SendNotify
{
    public function handle(AfterRegisted $event)
    {
        echo $event->data;
    }
}
