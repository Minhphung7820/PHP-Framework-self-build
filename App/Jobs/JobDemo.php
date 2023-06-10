<?php

namespace App\Jobs;

class JobDemo
{

    public function handle($a)
    {
        echo "Đây là job demo với tham số là : " . $a;
    }
}
