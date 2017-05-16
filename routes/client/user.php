<?php

use App\Etrack\Entities\Assets\Asset;
use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    /** @var Router $api */
//protected Routes
    $api->group(['middleware' => ['api.auth', 'user.active'], 'namespace' => 'App\Http\Controllers'], function ($api) {
        $api->get('client/user/events', 'Client\Users\UsersController@events');
        $api->get('client/user/notifications/latest', 'Notifications\NotificationsController@latest');
        $api->get('client/user/notifications', 'Notifications\NotificationsController@index');
        $api->post('client/user/notifications/read/{id}', 'Notifications\NotificationsController@read');
        $api->get('client/user/activities-to-execute', 'Client\Dashboard\UserDashboardController@activitiesToExecute');
        $api->get('client/user/supervised-activities', 'Client\Dashboard\UserDashboardController@supervisedActivities');
        $api->get('client/user/expired-activities', 'Client\Dashboard\UserDashboardController@expiredActivities');
        $api->get('client/user/activities-summary-graph', 'Client\Dashboard\UserDashboardController@activitiesSummaryGraph');
        $api->get('client/user/summary', 'Client\Dashboard\UserDashboardController@summary');
        $api->get('client/user/activities-summary-count', 'Client\Dashboard\UserDashboardController@activitiesSummaryCount');
    });
});