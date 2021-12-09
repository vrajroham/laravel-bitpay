<?php

namespace Vrajroham\LaravelBitpay;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Vrajroham\LaravelBitpay\Console\CreateKeypairCommand;
use Vrajroham\LaravelBitpay\Http\Controllers\WebhookController;


class LaravelBitpayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-bitpay.php' => config_path('laravel-bitpay.php'),
            ], 'config');
        }

        $this->registerRoutes();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-bitpay.php', 'laravel-bitpay');
        $this->app->bind('command.laravel-bitpay:createkeypair', CreateKeypairCommand::class);
        $this->commands([
            'command.laravel-bitpay:createkeypair',
        ]);
    }

    protected function registerRoutes()
    {
        Route::macro('bitPayWebhook',
            function (string $uri = 'laravel-bitpay/webhook') {
                Route::post($uri, [WebhookController::class, 'handleWebhook'])
                    ->name('laravel-bitpay.webhook.capture');
            });
    }
}
