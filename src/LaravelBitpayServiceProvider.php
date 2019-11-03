<?php

namespace Vrajroham\LaravelBitpay;

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
}
