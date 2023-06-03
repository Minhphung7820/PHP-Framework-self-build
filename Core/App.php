<?php

namespace Core;

use DI\ContainerBuilder;

class App
{
    private static $container;

    public static function getContainer()
    {
        if (!self::$container) {
            $containerBuilder = new ContainerBuilder();

            self::$container = $containerBuilder->build();
            self::$container->set(\Repositories\Interfaces\InterfaceProductRepository::class, function () {
                return new \Repositories\ProductRepository();
            });
            self::$container->set(\Http\Controllers\Frontend\ProductController::class, function () {
                return new \Http\Controllers\Frontend\ProductController(new \Repositories\ProductRepository(), "TAO NÈ MÀY", 2);
            });
        }

        return self::$container;
    }
}
