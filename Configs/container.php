<?php
return [
    'di' => [
        'Http\\Controllers\\Frontend\\ProductController' => ["a" => 5000, "b" => 20000]
    ],
    'itf_class' => [
        Repositories\Interfaces\InterfaceProductRepository::class => \DI\get(Repositories\ProductRepository::class),
    ]
];
