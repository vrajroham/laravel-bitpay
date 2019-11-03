<?php

$router->group(['prefix' => 'laravel-bitpay'], function ($router) {
    $router->post('/webhook', 'WebhookController@handleWebhook')->name('laravel-bitpay.webhook.capture');
});
