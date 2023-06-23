<?php

namespace App\Jobs;

use App\Jobs\Interfaces\BaseQueue;
use Supports\Facades\Traits\Dispatchable;
use Supports\Facades\Interfaces\ShouldQueue;
use Supports\Facades\Mail;

class SendMailJob implements BaseQueue, ShouldQueue
{
    use Dispatchable;
    public function handle()
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
