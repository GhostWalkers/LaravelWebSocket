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
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel websocket');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel websocket');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel websocket.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel websocket'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel websocket'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel websocket'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                StartWebSocketsCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel websocket');

        // Register the main class to use with the facade
        $this->app->singleton('laravel websocket', function () {
            return new LaravelWebsocket;
        });
    }
}
