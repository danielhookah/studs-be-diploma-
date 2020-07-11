<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => IS_DEV_MODE, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'jwt' => [
                'issuer' => 'studs.me',
                'lifetime' => getenv('AUTH_TTL'),
                'private_key' => file_get_contents(__DIR__ . '/private.pem'),
                'public_key' => file_get_contents(__DIR__ . '/public.pem')
//                'private_key' => str_replace('|||', PHP_EOL, getenv('PRIVATE_JWT_KEY')),
//                'public_key' => str_replace('|||', PHP_EOL, getenv('PRIVATE_JWT_KEY'))
            ]
        ],
    ]);
};
