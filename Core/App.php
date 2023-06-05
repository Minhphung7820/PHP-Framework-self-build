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

            /* Khai báo các Dependency injecttion tại đây  */

            self::$container->set(\Repositories\Interfaces\InterfaceProductRepository::class, function () {
                return new \Repositories\ProductRepository();
            });

            self::$container->set(\Closure::class, function () {
                return function (\Supports\Http\Request $request) {
                    return $request->NEXT_REQUEST;
                };
            });

            self::$container->set(\Http\Controllers\Frontend\ProductController::class, function () {
                return new \Http\Controllers\Frontend\ProductController(new \Repositories\ProductRepository(), "DORAEMON", "NOBITA");
            });

            /*  ==================================================== */
        }

        return self::$container;
    }
}
