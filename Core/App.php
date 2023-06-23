<?php

namespace Core;

use DI\ContainerBuilder;
use App\Models\ProductsModel;

/**
 * Ứng dụng chính của framework.
 *
 * Lớp `App` đại diện cho ứng dụng chính của framework, có nhiệm vụ quản lý container và khai báo các Dependency Injection.
 * Cung cấp phương thức để truy cập vào container và lấy các đối tượng được khai báo.
 *
 * @package Core
 */
class App
{
    /**
     * Đối tượng container.
     *
     * Đây là một thuộc tính tĩnh của lớp `App` dùng để lưu trữ đối tượng container của DI (Dependency Injection).
     * Container được sử dụng để quản lý và cung cấp các đối tượng trong ứng dụng.
     *
     * @author	Truong Minh Phung Back-End PHP Developer
     * @var Container
     */
    private static $container;

    /**
     * Phương thức để lấy đối tượng container.
     *
     * Nếu container chưa được khởi tạo, phương thức sẽ tạo mới container và khai báo các Dependency Injection.
     * Sau đó, container sẽ được lưu trữ vào thuộc tính `$container`.
     *
     * @return Container Đối tượng container của ứng dụng.
     */
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
