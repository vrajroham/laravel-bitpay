<?php

namespace Vrajroham\LaravelBitpay\Http\Controllers;

use Illuminate\Http\Request;
use Vrajroham\LaravelBitpay\Events\BitpayWebhookReceived;
use Vrajroham\LaravelBitpay\Http\Middleware\VerifyWebhookSignature;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyWebhookSignature::class);
    }

    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        BitpayWebhookReceived::dispatch($payload);

        return response('OK', 200);
    }
}
