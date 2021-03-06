<?php

use CkmTiming\Controllers\v1\DocumentationController;
use CkmTiming\Controllers\v1\EventController;
use CkmTiming\Controllers\v1\SantosEndurance\ConfigurationController;
use CkmTiming\Controllers\v1\SantosEndurance\DriversController;
use CkmTiming\Controllers\v1\SantosEndurance\HealthController;
use CkmTiming\Controllers\v1\SantosEndurance\KartsBoxController;
use CkmTiming\Controllers\v1\SantosEndurance\StatsController;
use CkmTiming\Controllers\v1\SantosEndurance\TeamsController;
use CkmTiming\Controllers\v1\SantosEndurance\TimingController;
use CkmTiming\Controllers\v1\TokenController;
use CkmTiming\Middlewares\TokenMiddleware;
use CkmTiming\Enumerations\Routes;
use CkmTiming\Middlewares\EventMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group(Routes::API_VERSION, function (RouteCollectorProxy $group) {
    $group->get(Routes::DOCUMENTATION, DocumentationController::class . ':get');
});

$app->group('', function (RouteCollectorProxy $group) {
    $group->get(Routes::TOKEN_VALIDATE, TokenController::class . ':get');

    $group->group(Routes::API_VERSION, function (RouteCollectorProxy $group) {
        global $container;

        $group->get(Routes::EVENT, EventController::class . ':get');
        $group->post(Routes::EVENT, EventController::class . ':post');

        $group->group(Routes::EVENT_NAME, function (RouteCollectorProxy $group) {
            // Santos Endurance endpoints
            $group->get(Routes::SE_CONFIGURATION, ConfigurationController::class . ':get');
            $group->put(Routes::SE_CONFIGURATION, ConfigurationController::class . ':put');
            $group->put(Routes::SE_CONFIGURATION_NAME, ConfigurationController::class . ':putByName');
            
            $group->get(Routes::SE_HEALTH, HealthController::class . ':get');
            $group->put(Routes::SE_HEALTH_NAME, HealthController::class . ':putByName');

            $group->get(Routes::SE_KARTS_BOX_ACTION, KartsBoxController::class . ':get');
            $group->post(Routes::SE_KARTS_BOX_ACTION, KartsBoxController::class . ':post');
            $group->put(Routes::SE_KARTS_BOX_ACTION, KartsBoxController::class . ':put');

            $group->get(Routes::SE_STATS, StatsController::class . ':get');
            $group->get(Routes::SE_STATS_NAME, StatsController::class . ':getByName');
            $group->put(Routes::SE_STATS_NAME, StatsController::class . ':putByName');
            
            $group->get(Routes::SE_TEAMS, TeamsController::class . ':get');
            $group->post(Routes::SE_TEAMS, TeamsController::class . ':post');
            $group->get(Routes::SE_TEAMS_NAME, TeamsController::class . ':getByName');
            $group->put(Routes::SE_TEAMS_NAME, TeamsController::class . ':putByName');
            $group->get(Routes::SE_TEAMS_DRIVER_NAME, DriversController::class . ':get');
            $group->post(Routes::SE_TEAMS_DRIVER_NAME, DriversController::class . ':post');
            $group->put(Routes::SE_TEAMS_DRIVER_NAME, DriversController::class . ':put');

            $group->post(Routes::SE_TIMING, TimingController::class . ':post');
            $group->get(Routes::SE_TIMING_ALL, TimingController::class . ':getAll');
            $group->get(Routes::SE_TIMING_TEAM, TimingController::class . ':getByTeamName');
            $group->put(Routes::SE_TIMING_KART_STATUS, TimingController::class . ':putKartStatus');
        })->add(new EventMiddleware($container));
    });
})->add(new TokenMiddleware($container));
