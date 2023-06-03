<?php
return [
    '/' => [
        'handler' => [\Http\Controllers\Frontend\HomeController::class, 'index'],

    ],
    '/san-pham/{cate}/{slug}.html' => [
        'handler' => [\Http\Controllers\Frontend\ProductController::class, 'detail'],
        'middlewares' => [
            \Http\Middlewares\CheckLogin::class,
            \Http\Middlewares\CheckRole::class
        ]
    ],
    '/san-pham' => [
        'handler' => [\Http\Controllers\Frontend\ProductController::class, 'all'],
    ],
    '/lien-he' => [
        'handler' => function () {
            return view('frontend.contact.index');
        },
        'middlewares' => [
            \Http\Middlewares\CheckLogin::class,
        ]
    ]
];
