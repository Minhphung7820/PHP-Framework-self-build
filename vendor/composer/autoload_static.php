<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9436c7ebb492eb130c72f4ee39f514c8
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Views\\' => 6,
        ),
        'S' => 
        array (
            'Supports\\' => 9,
        ),
        'P' => 
        array (
            'Public\\' => 7,
        ),
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'H' => 
        array (
            'Http\\' => 5,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Views\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Views',
        ),
        'Supports\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Supports',
        ),
        'Public\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Public',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Models',
        ),
        'Http\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Http',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9436c7ebb492eb130c72f4ee39f514c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9436c7ebb492eb130c72f4ee39f514c8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9436c7ebb492eb130c72f4ee39f514c8::$classMap;

        }, null, ClassLoader::class);
    }
}
