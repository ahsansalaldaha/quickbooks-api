<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Lumen\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Clients\Quickbook as QuickBooks;


/**
 * Class Filter
 *
 * @package Spinen\QuickBooks
 */
class QuickbooksAuthMiddleware
{
    /**
     * The QuickBooks client instance.
     *
     * @var Client
     */
    protected $quickbooks;

    /**
     * The UrlGenerator instance.
     *
     * @var UrlGenerator
     */
    protected $url_generator;

    /**
     * Create a new QuickBooks filter middleware instance.
     *
     * @param QuickBooks $quickbooks
     * @param Session $session
     * @param UrlGenerator $url_generator
     */
    public function __construct(
        QuickBooks $quickbooks,
        UrlGenerator $url_generator
    ) {
        $this->quickbooks = $quickbooks;
        $this->url_generator = $url_generator;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request Request
     * @param Closure $next Closure
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->quickbooks->hasValidRefreshToken()) {
            // Set intended route, so that after linking account, user is put where they were going
            $request->session()->put('url.intended', $this->url_generator->to($request->path()));

            return redirect()->route('quickbooks.connect');
        }
        return $next($request);
    }
}
