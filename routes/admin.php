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
    $api->group(['prefix' => 'admin', 'middleware' => ['api.auth', 'user.active'], 'namespace' => 'App\Http\Controllers'], function ($api) {
        /** @var Router $api */
        $api->get('companies/datatable', 'Admin\Company\CompanyController@datatable');
        $api->put('companies/toggle-active/{id}', 'Admin\Company\CompanyController@toggleActive');
        $api->resource('companies', 'Admin\Company\CompanyController', ['except' => ['edit', 'create']]);

        $api->get('permissions', 'Admin\Permissions\PermissionsAdminController@index');
        $api->get('users/datatable', 'Admin\Users\UsersAdminController@datatable');
        $api->get('roles/datatable', 'Admin\Roles\RolesAdminController@datatable');
        $api->resource('roles', 'Admin\Roles\RolesAdminController', ['except' => ['edit', 'create']]);
        $api->resource('users', 'Admin\Users\UsersAdminController', ['except' => ['edit', 'create']]);
    });

});