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
        $api->get('activities/users/{subject}/search', 'Client\Activities\ActivitiesSupervisorOperatorController@search');
        $api->get('activities/{activityId}/assets', 'Client\Activities\ActivitiesAssetsController@datatable');
        $api->get('activities/{activityId}/assets/search', 'Client\Activities\ActivitiesAssetsController@search');
        $api->get('activities/program-types', 'Client\Activities\ProgramTypesController@index');

        $api->resource('activities/{activityId}/schedules', 'Client\Activities\ActivitiesSchedulesController');

        $api->get('activities/templates/datatable', 'Client\Activities\TemplatesController@datatable');
        $api->put('activities/templates/{templateId}/toggle-active', 'Client\Activities\TemplatesController@toggleActive');
        $api->resource('activities/templates', 'Client\Activities\TemplatesController', ['except' => ['edit', 'create']]);

        $api->get('activities/datatable', 'Client\Activities\ActivitiesController@datatable');
        $api->resource('activities', 'Client\Activities\ActivitiesController', ['except' => ['edit', 'create']]);
    });

});