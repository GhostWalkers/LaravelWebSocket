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
                __DIR__ . '/Config/config.php' => config_path('laravelwebsocket.php'),
            ], 'config');

            $this->commands([
                StartWebSocketsCommand::class
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravelwebsocket');

        $this->app->singleton('laravel websocket', function () {
            return new LaravelWebsocket;
        });
    }
}
