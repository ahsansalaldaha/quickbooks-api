<?php

use Laravel\Lumen\Routing\Router;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'quickbooks'], function (Router $router) {
    $router->get('connect', ['as' => 'quickbooks.connect', 'uses' => 'QuickbookConnectController@connect']);
    $router->delete('disconnect', ['as' => 'quickbooks.disconnect', 'uses' => 'QuickbookConnectController@disconnect']);
    $router->get('token', ['as' => 'quickbooks.token', 'uses' => 'QuickbookConnectController@token']);
});

$router->get('company-info', 'APIController@companyInfo');
