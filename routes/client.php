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
        $api->put('user/{id}', 'Client\User\UserController@update');
        $api->post('user/change-password', 'Client\User\UserController@changePassword');
        $api->get('permission', 'Client\Permission\PermissionController@index');
        $api->get('role/datatable', 'Client\Role\RoleController@datatable');
        $api->get('secure-user/datatable', 'Client\User\SecureUserController@datatable');
        $api->get('worker/datatable', 'Client\Worker\WorkerController@datatable');
        $api->resource('worker', 'Client\Worker\WorkerController', ['except' => ['edit', 'create']]);
        $api->resource('role', 'Client\Role\RoleController', ['except' => ['edit', 'create']]);
        $api->resource('secure-user', 'Client\User\SecureUserController', ['except' => ['edit', 'create']]);
    });

});