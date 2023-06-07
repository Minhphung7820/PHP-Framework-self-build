<?php

namespace Core;

use DI\ContainerBuilder;
use App\Models\ProductsModel;

class App
{
    private static $container;

    public static function getContainer()
    {
        if (!self::$container) {
            $containerBuilder = new ContainerBuilder();

            self::$container = $containerBuilder->build();

            /* Khai báo các Dependency injecttion tại đây  */

            self::$container->set(\App\Repositories\Interfaces\InterfaceProductRepository::class, function () {
                return new \App\Repositories\ProductRepository(new ProductsModel);
            });

            self::$container->set(\Closure::class, function () {
                return function (\Supports\Http\Request $request) {
                    return $request->NEXT_REQUEST;
                };
            });

            self::$container->set(\App\Http\Controllers\Frontend\ProductController::class, function () {
                return new \App\Http\Controllers\Frontend\ProductController(new \App\Repositories\ProductRepository(new ProductsModel), "DORAEMON", "NOBITA");
            });

            /*  ==================================================== */
        }

        return self::$container;
    }
}
