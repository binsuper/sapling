<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit52fa8b9f9a042f3539ca44b9c9217fae
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Plugin\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Plugin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/plugins',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit52fa8b9f9a042f3539ca44b9c9217fae::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit52fa8b9f9a042f3539ca44b9c9217fae::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}