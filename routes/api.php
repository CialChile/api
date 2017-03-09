<?php

use App\Etrack\Entities\Auth\User;
use Dingo\Api\Routing\Router;
use Tymon\JWTAuth\Facades\JWTAuth;

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
    $api->group(['middleware' => ['api.auth'], 'namespace' => 'App\Http\Controllers'], function ($api) {
        /** @var Router $api */
        $api->get('auth/permissions', 'Auth\AuthController@permissions');
        $api->post('auth/logout', 'Auth\AuthController@logout');
        $api->get('auth/user', 'Auth\AuthController@user');

        $api->get('company/datatable', 'Admin\Company\CompanyController@datatable');
        $api->resource('company', 'Admin\Company\CompanyController', ['except' => ['edit', 'create']]);

        $api->get('company-field/list', 'Admin\Company\CompanyFieldController@list');
        $api->get('company-field/datatable', 'Admin\Company\CompanyFieldController@datatable');
        $api->resource('company-field', 'Admin\Company\CompanyFieldController', ['except' => ['edit', 'create']]);

        $api->get('country', 'Location\CountryController@index');
        $api->get('state/{country}', 'Location\StateController@index');
    });

    //unprotected Routes
    $api->group(['middleware' => [], 'namespace' => 'App\Http\Controllers'], function ($api) {
        /** @var Router $api */
        $api->post('auth/login', 'Auth\AuthController@login');
    });
});