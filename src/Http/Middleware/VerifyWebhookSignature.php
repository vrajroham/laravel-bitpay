<?php

namespace Vrajroham\LaravelBitpay\Http\Middleware;

use Closure;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyWebhookSignature
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     *
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        try {
            // Verify signature
        } catch (Exception $exception) {
            throw new AccessDeniedHttpException($exception->getMessage(), $exception);
        }

        return $next($request);
    }
}
