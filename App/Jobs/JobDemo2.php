<?php

namespace App\Jobs;

class JobDemo2
{

    public function handle($a)
    {
        echo "Đây là giúp demo 2 với tham số là : " . $a;
    }
}
