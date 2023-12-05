<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class CustomThrottleMiddleware extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected function resolveRequestSignature($request)
    {
        // Throttle by a request parameter
        return $request->input('account_id');
    }

    protected function handleRequest($request, Closure $next, array $limits)
    {
        dd($this->throttleKey());
//        return 0;
    }
}
