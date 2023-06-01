<?php
return [
    'parameters_class' => [
        'Http\\Controllers\\Frontend\\ProductController' => ["a" => 5000, "b" => 20000]
    ],
    'binding_class' => [
        Repositories\Interfaces\InterfaceProductRepository::class => \DI\get(Repositories\ProductRepository::class),
    ]
];
