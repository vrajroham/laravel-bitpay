<?php

namespace Vrajroham\LaravelBitpay;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Vrajroham\LaravelBitpay\Commands\CreateKeypair;

class LaravelBitpayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-bitpay.php' => config_path('laravel-bitpay.php'),
            ], 'config');
        }

        $this->defineRoutes();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-bitpay.php', 'laravel-bitpay');
        $this->app->bind('command.laravel-bitpay:createkeypair', CreateKeypair::class);
        $this->commands([
            'command.laravel-bitpay:createkeypair',
        ]);
    }

    protected function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            Route::group(
                ['namespace' => 'Vrajroham\LaravelBitpay\Http\Controllers'],
                function ($router) {
                    require __DIR__.'/Http/Routes/web.php';
                }
            );
        }
    }
}
