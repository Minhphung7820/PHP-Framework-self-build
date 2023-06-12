<?php

namespace App\Jobs;

use App\Models\ProductsModel;
use Supports\Facades\Mail;

class JobDemo2
{

    public function handle(ProductsModel $productsModel, $a)
    {
        $data = [
            'subject' => 'Mail DEMO',
            'body' => 'Hello World',
            'email' => 'phungtmps15106@fpt.edu.vn',
            'name' => 'Trương Minh Phụng'
        ];
        $mail = new Mail($data);
        $mail->send();
    }
}
