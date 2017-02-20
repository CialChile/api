<?php

use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/** @var Router $api */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    /** @var Router $api */
    //protected Routes
    $api->group(['middleware' => 'api.auth'], function ($api) {
        /** @var Router $api */
        $api->get('users', function () {
            return 'ok';
        });
    });

    //unprotected Routes
    $api->group([], function ($api) {
        /** @var Router $api */
        $api->get('users2', function () {
            return 'ok';
        });
    });
});