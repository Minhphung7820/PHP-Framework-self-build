<?php

namespace App\Jobs;

use App\Models\ProductsModel;
use Supports\Facades\Traits\Dispatchable;
use Supports\Facades\Interfaces\ShouldQueue;
use Supports\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable;
    public function handle(ProductsModel $prod)
    {
        $data = [
            'email' => 'phungtmps15106@fpt.edu.vn',
            'name' => 'Phụng',
            'subject' => 'Test queue - GFW',
            'body' => 'Say Hello'
        ];
        (new Mail($data))->send();
    }
}
