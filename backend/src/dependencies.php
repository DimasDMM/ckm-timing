<?php

use CkmTiming\Helpers\EventCreator;
use CkmTiming\Helpers\ValidatorTypes;
use CkmTiming\Helpers\ValidatorRanges;
use CkmTiming\Storages\v1\Common\EventsIndexStorage;
use CkmTiming\Storages\v1\SantosEndurance\ConfigurationStorage;
use CkmTiming\Storages\v1\SantosEndurance\StatsStorage;
use CkmTiming\Storages\v1\SantosEndurance\TimingStorage;
use Psr\Container\ContainerInterface as Container;

// Storages
$callbacks = [
    'common' => [
        'events_index' => function () use ($container) { return new EventsIndexStorage($container); },
    ],
    'santos_endurance' => [
        'configuration' => function () use ($container) { return new ConfigurationStorage($container); },
        'stats' => function () use ($container) { return new StatsStorage($container); },
        'timing' => function () use ($container) { return new TimingStorage($container); },
    ],
];
$container->set('storages', $callbacks);

// Helpers
$container->set('validator_types', function (Container $container) { return new ValidatorTypes($container); });
$container->set('validator_ranges', function (Container $container) { return new ValidatorRanges($container); });
$container->set('event_creator', function (Container $container) { return new EventCreator($container); });
