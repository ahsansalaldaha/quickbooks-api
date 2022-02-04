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
$router->group(
    ['middleware' => ['logging']],
    function (Router $router) {

        $router->group(['prefix' => 'quickbooks'], function (Router $router) {
            $router->get('connect', ['as' => 'quickbooks.connect', 'uses' => 'QuickbookConnectController@connect']);
            $router->delete('disconnect', ['as' => 'quickbooks.disconnect', 'uses' => 'QuickbookConnectController@disconnect']);
            $router->get('token', ['as' => 'quickbooks.token', 'uses' => 'QuickbookConnectController@token']);
        });

        $router->group(
            ['middleware' =>  'quickbooks'],
            function (Router $router) {

                $router->get('company-info', 'APIController@companyInfo');

                // Customer Routes
                $router->group(
                    ['prefix' => 'customers'],
                    function (Router $router) {
                        $router->get('/', 'CustomerAPIController@index');
                        $router->get('/{id}', 'CustomerAPIController@show');
                        $router->post('/', 'CustomerAPIController@store');
                        $router->put('/{id}', 'CustomerAPIController@update');
                        $router->delete('/{id}', 'CustomerAPIController@delete');
                    }
                );
            }
        );
    }
);
