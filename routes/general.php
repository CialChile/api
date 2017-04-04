<?php

use App\Etrack\Entities\Assets\Asset;
use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    /** @var Router $api */
//protected Routes
    $api->group(['middleware' => ['api.auth','user.active'], 'namespace' => 'App\Http\Controllers'], function ($api) {
        /** @var Router $api */
        $api->get('auth/permissions', 'Auth\AuthController@permissions');
        $api->post('auth/logout', 'Auth\AuthController@logout');
        $api->get('auth/user', 'Auth\AuthController@getUser');

        $api->get('company-fields/list', 'Admin\Company\CompanyFieldController@list');
        $api->get('company-fields/datatable', 'Admin\Company\CompanyFieldController@datatable');
        $api->resource('company-fields', 'Admin\Company\CompanyFieldController', ['except' => ['edit', 'create']]);

        $api->get('countries', 'Locations\CountriesController@index');
        $api->get('states/{country}', 'Locations\StatesController@index');
    });

//unprotected Routes
    $api->group(['middleware' => [], 'namespace' => 'App\Http\Controllers'], function ($api) {
        /** @var Router $api */
        $api->post('auth/login', 'Auth\AuthController@login');
        $api->get('test',function(){
           $asset = Asset::first();
            $assetImages = $asset->getMedia('images');
            dd($assetImages);
        });
    });
});