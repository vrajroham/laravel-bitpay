<?php

namespace Vrajroham\LaravelBitpay;

use Vrajroham\LaravelBitpay\Commands\CreateKeypair;
use Illuminate\Support\ServiceProvider;

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

            /*
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'skeleton');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/skeleton'),
            ], 'views');
            */
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-bitpay.php', 'laravel-bitpay');
        $this->app->bind('command.laravel-bitpay:createkeypair', CreateKeypair::class);
        $this->commands([
            'command.laravel-bitpay:createkeypair'
        ]);
    }
}
