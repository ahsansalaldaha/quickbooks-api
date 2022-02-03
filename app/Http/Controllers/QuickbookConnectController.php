<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Routing\Redirector;
use App\Clients\Quickbook as QuickBooks;

/**
 * Class Controller
 *
 * @package App\Http\Controller
 */
class QuickbookConnectController extends Controller
{
    // NOTE: When using constructor injection for QuickBooks, there is a race issue with the boot order of the app

    /**
     * Form to connect/disconnect user to QuickBooks
     *
     * If the user has a valid OAuth, then give form to disconnect, otherwise link to connect it
     *
     * @param QuickBooks $quickbooks
     * @param ViewFactory $view_factory
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\View\View
     * @throws \QuickBooksOnline\API\Exception\SdkException
     * @throws \QuickBooksOnline\API\Exception\ServiceException
     */
    public function connect(QuickBooks $quickbooks, ViewFactory $view_factory)
    {
        // Give view to remove token if user already linked account
        if ($quickbooks->hasValidRefreshToken()) {
            return view('disconnect')
                ->with('company', $quickbooks->getDataService()
                    ->getCompanyInfo());
        }

        // Give view to link account
        return view('connect')
            ->with('authorization_uri', $quickbooks->authorizationUri());
    }

    /**
     * Removes the token
     *
     * @param Redirector $redirector
     * @param QuickBooks $quickbooks
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function disconnect(Redirector $redirector, Request $request, QuickBooks $quickbooks)
    {
        $quickbooks->deleteToken();

        $request->session()->flash('success', 'Disconnected from QuickBooks');

        return $redirector->back();
    }

    /**
     * Accept the code from QuickBooks to request token
     *
     * Once a user approves linking account, then QuickBooks sends back
     * a code which can be converted to an OAuth token.
     *
     * @param Redirector $redirector
     * @param Request $request
     * @param QuickBooks $quickbooks
     * @param UrlGenerator $url_generator
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \QuickBooksOnline\API\Exception\SdkException
     * @throws \QuickBooksOnline\API\Exception\ServiceException
     */
    public function token(Request $request, QuickBooks $quickbooks)
    {
        // TODO: Deal with exceptions
        $quickbooks->exchangeCodeForToken($request->get('code'), $request->get('realmId'));

        return "Success, Now you can use the QuickBooks API";
    }
}
