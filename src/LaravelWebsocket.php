<?php

namespace Ghostwalker;

use AllowDynamicProperties;
use Ghostwalker\Service\UtilService;
use JetBrains\PhpStorm\Pure;
use Ratchet\App;
use Nette\Loaders\RobotLoader;
use Illuminate\Container\Container;
use ReflectionException;

#[AllowDynamicProperties] class LaravelWebsocket
{
    /**
     * @var App
     */
    public static App $app;

    /**
     * @var RobotLoader
     */
    public static RobotLoader $robotLoader;

    /**
     * @var string
     */
    public string $httpHost = 'localhost';

    /**
     * @var int
     */
    public int $port = 8080;

    /**
     * @return void
     */
    public function bootApp(): void
    {
        self::$app = new App(env('sockets_httphost') ?? $this->httpHost, env('sockets_port') ?? $this->port);
    }

    /**
     * __construct
     */
    #[Pure] public function __construct()
    {
        $this->utilService = new UtilService();
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function bootStrap()
    {
        $this->bootApp();
        $this->bootLoader();
        $this->touchMethod();
    }

    /**
     * @return void
     */
    protected function bootLoader()
    {
        $loader = self::$robotLoader = new RobotLoader();
        $loader->setTempDirectory(__DIR__ . '/Temp');
        $loader->addDirectory(env('SOCKETS_DIR'));
        $loader->rebuild();
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    protected function touchMethod()
    {
        foreach (self::$robotLoader->getIndexedClasses() as $indexedClass => $path) {
            $this->utilService->checkOnMethod('addRout', $indexedClass);
            $indexedClass::addRout();
        }
    }
}

