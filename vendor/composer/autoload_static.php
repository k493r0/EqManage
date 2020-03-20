<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbcb39047e041765b137241d45eae2315
{
    public static $files = array (
        'bdffba51b95e502d380f6113430270a2' => __DIR__ . '/../..' . '/src/functions-dev.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
        'M' => 
        array (
            'Mpdf\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
        'Mpdf\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
            1 => __DIR__ . '/../..' . '/tests/Mpdf',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbcb39047e041765b137241d45eae2315::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbcb39047e041765b137241d45eae2315::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
