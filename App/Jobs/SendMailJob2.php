<?php

namespace App\Jobs;

use App\Models\ProductsModel;
use Supports\Facades\Traits\Dispatchable;
use Supports\Facades\Interfaces\ShouldQueue;
use Supports\Facades\Mail;

class SendMailJob2 implements ShouldQueue
{
    use Dispatchable;
    public function handle(ProductsModel $prod)
    {
        $data = [
            'email' => 'minhphung485@gmail.com',
            'name' => 'Phụng Channel',
            'subject' => 'Test queue - GFW',
            'body' => 'mmmmmmmmmmmmmmmmmmmmm'
        ];
        (new Mail($data))->send();
    }
}
