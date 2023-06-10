<?php

namespace App\Jobs;

class JobDemo2
{

    public function handle($a)
    {
        echo "Đây là job demo 2 với tham số là : " . $a;
    }
}
