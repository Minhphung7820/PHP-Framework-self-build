<?php
return [
    'redis' => [
        'scheme' => env('REDIS_SCHEME'),
        'host' => env('REDIS_HOST'),
        'port' => env('REDIS_PORT'),
        'database' => env('REDIS_DATABASE'),
        'read_write_timeout' => env('REDIS_READ_WRITE_TIMEOUT')
    ]
];
