<?php

namespace Ghostwalker;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ghostwalker\Commands\LaravelWebsocket\Skeleton\SkeletonClass
 */
class LaravelWebsocketFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel websocket';
    }
}
