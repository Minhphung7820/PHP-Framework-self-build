<?php

namespace App\Events;


class DemoEvent
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}
