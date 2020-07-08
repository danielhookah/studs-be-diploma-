<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

require __DIR__ . "/../config/DBconfig.php";

return function (ContainerBuilder $containerBuilder) use ($dbConfigConnectionOptions) {
    /** LOGGER **/
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);

    /** DOCTRINE ORM **/
    $containerBuilder->addDefinitions([
        EntityManagerInterface::class => function (ContainerInterface $c) use ($dbConfigConnectionOptions) {
            $cache = IS_DEV_MODE ? new \Doctrine\Common\Cache\ArrayCache : new \Doctrine\Common\Cache\ApcCache;

            $config = new Configuration;
            $config->setMetadataCacheImpl($cache);
            $driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/../../src', false);
            $config->setMetadataDriverImpl($driverImpl);
            $config->setQueryCacheImpl($cache);
            $config->setProxyDir(__DIR__ . '/../var/cache/doctrine-proxies');
            $config->setProxyNamespace('App\Proxies');

            if (IS_DEV_MODE) {
                $config->setAutoGenerateProxyClasses(true);
            } else {
                $config->setAutoGenerateProxyClasses(false);
                // doctrine orm:generate-proxies
            }

            return $em = EntityManager::create($dbConfigConnectionOptions, $config);
        }
    ]);
};
