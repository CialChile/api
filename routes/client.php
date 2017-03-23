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
    $api->group(['prefix' => 'client', 'middleware' => ['api.auth'], 'namespace' => 'App\Http\Controllers'], function ($api) {
        /** @var Router $api */
        $api->put('user/{id}', 'Client\Users\UsersController@update');
        $api->post('user/change-password', 'Client\Users\UsersController@changePassword');
        $api->get('permissions', 'Client\Permissions\PermissionsController@index');

        $api->get('workers/datatable', 'Client\Workers\WorkersController@datatable');
        $api->resource('workers', 'Client\Workers\WorkersController', ['except' => ['edit', 'create']]);

        $api->get('assets/datatable', 'Client\Assets\AssetsController@datatable');

        $api->get('roles/datatable', 'Client\Roles\RolesController@datatable');
        $api->resource('roles', 'Client\Roles\RolesController', ['except' => ['edit', 'create']]);

        $api->get('secure-users/datatable', 'Client\Users\SecureUsersController@datatable');
        $api->resource('secure-users', 'Client\Users\SecureUsersController', ['except' => ['edit', 'create']]);
    });

});