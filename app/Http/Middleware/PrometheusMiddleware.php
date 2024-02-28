<?php

namespace App\Http\Middleware;

use App\Metrics\Prometheus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PrometheusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $duration = microtime(true) - LARAVEL_START;
        $histogram = Prometheus::getOrRegisterHistogram(
            "app",
            "response_time_seconds",
            "The response time of a request",
            ['method', 'route', 'status_code'],
            [0.1, 0.2, 0.3, 0.4, 0.5, 0.9, 1.0, 1.5, 2.0]
        );
        Log::info("Duration: $duration");
        $histogram->observe(
            $duration,
             [
                $request->method(),
                $request->getUri(),
                $response->getStatusCode(),
            ]
        );

        return $response;
    }
}
