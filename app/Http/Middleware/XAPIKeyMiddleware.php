<?php

namespace App\Http\Middleware;

use Closure;

class XAPIKeyMiddleware
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
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->headers->has('x-api-key')) {
            if ($request->header('x-api-key') === env('X_API_KEY')) {
                return $next($request);
            }
        }
        return response('Unauthorized.', 401);
    }
}
