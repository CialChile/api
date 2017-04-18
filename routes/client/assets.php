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
        $api->get('assets/config', 'Client\Assets\AssetsConfigurationController@index');
        $api->post('assets/config', 'Client\Assets\AssetsConfigurationController@store');

        $api->post('assets/{id}/certifications/{certificationId}/documents', 'Client\Assets\AssetCertificationsController@uploadDocuments');
        $api->get('assets/{assetId}/certifications/{certificationId}/documents/{documentId}', 'Client\Assets\AssetCertificationsController@downloadDocument');
        $api->delete('assets/{id}/certifications/{certificationId}/documents/{documentId}', 'Client\Assets\AssetCertificationsController@removeDocument');
        $api->resource('assets/{id}/certifications', 'Client\Assets\AssetCertificationsController', ['except' => ['edit', 'create']]);

        $api->get('assets/datatable', 'Client\Assets\AssetsController@datatable');
        $api->post('assets/{id}/images', 'Client\Assets\AssetsController@uploadImages');
        $api->post('assets/{id}/documents', 'Client\Assets\AssetsController@uploadDocuments');
        $api->get('assets/{assetId}/documents/{documentId}', 'Client\Assets\AssetsController@downloadDocument');
        $api->delete('assets/{id}/documents/{documentId}', 'Client\Assets\AssetsController@removeDocument');
        $api->delete('assets/{id}/images/{imageId}', 'Client\Assets\AssetsController@removeImage');
        $api->resource('assets', 'Client\Assets\AssetsController', ['except' => ['edit', 'create']]);

        $api->get('assets/config/workplaces/datatable', 'Client\Assets\WorkplacesController@datatable');
        $api->resource('assets/config/workplaces', 'Client\Assets\WorkplacesController', ['except' => ['edit', 'create']]);

        $api->get('assets/config/categories/datatable', 'Client\Assets\CategoriesController@datatable');
        $api->resource('assets/config/categories', 'Client\Assets\CategoriesController', ['except' => ['edit', 'create']]);

        $api->get('assets/config/categories/{categoryId}/subcategories/datatable', 'Client\Assets\SubcategoriesController@datatable');
        $api->resource('assets/config/categories/{categoryId}/subcategories', 'Client\Assets\SubcategoriesController', ['except' => ['edit', 'create']]);

        $api->get('assets/config/brands/datatable', 'Client\Assets\BrandsController@datatable');
        $api->resource('assets/config/brands', 'Client\Assets\BrandsController', ['except' => ['edit', 'create']]);

        $api->get('assets/config/brands/{brandId}/brand-models/datatable', 'Client\Assets\BrandModelsController@datatable');
        $api->resource('assets/config/brands/{brandId}/brand-models', 'Client\Assets\BrandModelsController', ['except' => ['edit', 'create']]);

    });

});