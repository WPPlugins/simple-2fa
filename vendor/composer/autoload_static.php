<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit57fc47bf2cfbb1e3d1ec9a52017fab5b
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'chillerlan\\QRCode\\' => 18,
            'chillerlan\\GoogleAuth\\' => 22,
            'chillerlan\\Base32\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'chillerlan\\QRCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-qrcode/src',
        ),
        'chillerlan\\GoogleAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-googleauth/src',
        ),
        'chillerlan\\Base32\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-base32/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit57fc47bf2cfbb1e3d1ec9a52017fab5b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit57fc47bf2cfbb1e3d1ec9a52017fab5b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
