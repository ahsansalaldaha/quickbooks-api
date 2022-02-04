<?php

namespace App\Http\Middleware;

use Closure;


class LoggingMiddleware
{
    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestData = [];
        $requestData['data'] = json_encode($request->all());
        $requestData['headers'] = json_encode($request->header());
        $arrival = microtime(true);

        $log = new \App\Models\Log();
        $log->request = json_encode($requestData);
        $log->url = $request->fullUrl();
        $log->ip_address = $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $request->ip();
        $log->arrival_time = (string) $arrival;
        $log->save();

        $result = $next($request);

        $log->response = substr(json_encode($result, true), 0, 65500);
        if ((string)$log->response == "{\"headers\":{},\"original\":{},\"exception\":null}") {
            $log->response = substr($result, 0, 65500);
        }
        $departure = microtime(true);
        $log->departure_time = (string)  $departure;
        $log->duration = (string) round($departure - $arrival, 3);
        $log->save();
        return $result;
    }
}
