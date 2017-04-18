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
    $api->group(['prefix' => 'client', 'middleware' => ['api.auth', 'user.active'], 'namespace' => 'App\Http\Controllers'], function ($api) {
        /** @var Router $api */
        $api->get('workers/datatable', 'Client\Workers\WorkersController@datatable');
        $api->get('workers/search/by-name/{name?}', 'Client\Workers\WorkersController@searchByName');
        $api->resource('workers', 'Client\Workers\WorkersController', ['except' => ['edit', 'create']]);

        $api->post('workers/{id}/certifications/{certificationId}/documents', 'Client\Workers\WorkersCertificationsController@uploadDocuments');
        $api->get('workers/{workerId}/certifications/{certificationId}/documents/{documentId}', 'Client\Workers\WorkersCertificationsController@downloadDocument');
        $api->delete('workers/{id}/certifications/{certificationId}/documents/{documentId}', 'Client\Workers\WorkersCertificationsController@removeDocument');
        $api->resource('workers/{id}/certifications', 'Client\Workers\WorkersCertificationsController', ['except' => ['edit', 'create']]);

    });

});