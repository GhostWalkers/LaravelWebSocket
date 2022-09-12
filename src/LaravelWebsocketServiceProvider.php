<?php

namespace Ghostwalker;

use Ghostwalker\Commands\StartWebSocketsCommand;
use Illuminate\Support\ServiceProvider;


class LaravelWebsocketServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel websocket.php'),
            ], 'config');

            $this->commands([
                StartWebSocketsCommand::class
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel websocket');

        $this->app->singleton('laravel websocket', function () {
            return new LaravelWebsocket;
        });
    }
}
