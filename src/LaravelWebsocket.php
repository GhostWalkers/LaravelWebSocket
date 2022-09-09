<?php

namespace Ghostwalker;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Support\Facades\Artisan;
use Ratchet\App;
use Nette\Loaders\RobotLoader;

class LaravelWebsocket
{
    public static App $app;

    public static RobotLoader $robotLoader;

    public static function bootApp(): void
    {
        self::$app = new App('localhost', 8080);
    }


    public static function bootStrap()
    {
        self::bootApp();
        self::bootLoader();
        self::createAllClass();
    }

//    public static function createOrGet(mixed $propety)
//    {
//        self::$propety ?? self::$propety = new self::$propety;
//    }

    public static function bootLoader()
    {
        $loader = self::$robotLoader = new RobotLoader();
        $loader->setTempDirectory(__DIR__ . '/temp');
        $loader->addDirectory(env('SOCKETS_DIR'));
        $loader->register();
    }

    public static function createAllClass()
    {
        foreach (self::$robotLoader->getIndexedClasses() as $indexedClass => $path) {
//            $reflectionIndexClass = new \ReflectionClass($indexedClass);
//            if ($reflectionIndexClass->getMethod('addRout'))
            $indexedClass::addRout();
        }
    }
}

