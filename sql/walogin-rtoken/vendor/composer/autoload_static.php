<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdb5f09ea70d95cd8af8054f85eea97f1
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BeycanPress\\Walogin\\RToken\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BeycanPress\\Walogin\\RToken\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdb5f09ea70d95cd8af8054f85eea97f1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdb5f09ea70d95cd8af8054f85eea97f1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdb5f09ea70d95cd8af8054f85eea97f1::$classMap;

        }, null, ClassLoader::class);
    }
}