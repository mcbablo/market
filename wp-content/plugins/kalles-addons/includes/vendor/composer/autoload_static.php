<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2c71958576d85ed2d8f1a336d0013038
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hybridauth\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hybridauth\\' => 
        array (
            0 => __DIR__ . '/..' . '/hybridauth/hybridauth/src',
        ),
    );

    public static $fallbackDirsPsr0 = array (
        0 => __DIR__ . '/..' . '/opauth/facebook',
        1 => __DIR__ . '/..' . '/opauth/google',
        2 => __DIR__ . '/..' . '/opauth/twitter',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Opauth' => __DIR__ . '/..' . '/opauth/opauth/lib/Opauth/Opauth.php',
        'OpauthStrategy' => __DIR__ . '/..' . '/opauth/opauth/lib/Opauth/OpauthStrategy.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2c71958576d85ed2d8f1a336d0013038::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2c71958576d85ed2d8f1a336d0013038::$prefixDirsPsr4;
            $loader->fallbackDirsPsr0 = ComposerStaticInit2c71958576d85ed2d8f1a336d0013038::$fallbackDirsPsr0;
            $loader->classMap = ComposerStaticInit2c71958576d85ed2d8f1a336d0013038::$classMap;

        }, null, ClassLoader::class);
    }
}
