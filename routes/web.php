<?php

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

$router->post('nfe/receive', 'ElectronicInvoiceController@receive');
$router->get('nfe', 'ElectronicInvoiceController@lists');
$router->get('nfe/{key}', 'ElectronicInvoiceController@show');
