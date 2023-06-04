<?php

/*
All mapping URLs in the Router/api directory must have the "/api" prefix before the URL.
*/
return [
    'name' => 'api.user',
    'middlewares' => ['checkLogin'],
    'routes' => [
        '/api/user/{id}' => [
            'handler' => [\Http\Controllers\Api\UserController::class, 'detail']
        ],
        '/api/user' => [
            'handler' => [\Http\Controllers\Api\UserController::class, 'all']
        ]
    ]
];
