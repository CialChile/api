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

        $api->get('certifications/datatable', 'Client\Certifications\CertificationsController@datatable');
        $api->get('certifications/search', 'Client\Certifications\CertificationsController@search');
        $api->post('certifications/{id}/documents', 'Client\Certifications\CertificationsController@uploadDocuments');
        $api->get('certifications/{assetId}/documents/{documentId}', 'Client\Certifications\CertificationsController@downloadDocument');
        $api->delete('certifications/{id}/documents/{documentId}', 'Client\Certifications\CertificationsController@removeDocument');
        $api->resource('certifications', 'Client\Certifications\CertificationsController', ['except' => ['edit', 'create']]);

        $api->get('certifications/config/institutes/datatable', 'Client\Institutes\InstitutesController@datatable');
        $api->resource('certifications/config/institutes', 'Client\Institutes\InstitutesController', ['except' => ['edit', 'create']]);
    });

});