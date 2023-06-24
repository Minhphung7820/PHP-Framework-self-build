<?php

namespace App\Jobs;

use App\Models\ProductsModel;
use Supports\Facades\Traits\Dispatchable;
use Supports\Facades\Interfaces\ShouldQueue;
use Supports\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function handle()
    {
        (new Mail($this->data))->send();
    }
}
