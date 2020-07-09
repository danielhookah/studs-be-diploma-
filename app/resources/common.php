<?php
declare(strict_types=1);

use App\Domain\Auth\Service\JwtAuth;
use DI\ContainerBuilder;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Selective\Csrf\CsrfMiddleware;
use Slim\Psr7\Factory\StreamFactory;

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

    /** AUTH **/
    $containerBuilder->addDefinitions([
        JwtAuth::class => function (ContainerInterface $container) {
            $config = $container->get('settings')['jwt'];

            $issuer = (string)$config['issuer'];
            $lifetime = (int)$config['lifetime'];
            $privateKey = (string)$config['private_key'];
            $publicKey = (string)$config['public_key'];

            return new JwtAuth($issuer, $lifetime, $privateKey, $publicKey);
        },
    ]);
    $containerBuilder->addDefinitions([
        StreamFactoryInterface::class => function (ContainerInterface $container) {
            return new StreamFactory();
        },
    ]);
    $containerBuilder->addDefinitions([
        CsrfMiddleware::class => function (ContainerInterface $container) {
            $responseFactory = $container->get(StreamFactoryInterface::class);

            $sessionId = session_id();

            $csrf = new CsrfMiddleware($responseFactory, $sessionId);
//            $csrf->protectjQueryAjax(false);

//            $csrf->setSalt('ghwvuc4asdtwf3co48');
            // Optional: Use the token from another source
            // By default the token will be generated automatically.
            //$csrf->setToken($token);

            return $csrf;
        }
    ]);
};
