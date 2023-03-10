<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbaf2fe2b5ea33acb0e7f7a8ff63fb79b
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Rakit\\Validation\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Rakit\\Validation\\' => 
        array (
            0 => __DIR__ . '/..' . '/rakit/validation/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbaf2fe2b5ea33acb0e7f7a8ff63fb79b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbaf2fe2b5ea33acb0e7f7a8ff63fb79b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbaf2fe2b5ea33acb0e7f7a8ff63fb79b::$classMap;

        }, null, ClassLoader::class);
    }
}
