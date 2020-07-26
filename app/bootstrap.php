<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'use_cookies'      => true,
        'use_only_cookies' => true,
        'use_trans_sid'    => false,
        'cookie_httponly'  => true,
        'cookie_lifetime'  => 0,
        'cookie_path'      => '/',
        'cache_limiter'    => ''
    ]);
}

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/functions.php';

// Load all custom env vars
$dotenv = Dotenv::create(__DIR__ . '/../');
$dotenv->load();

define("IS_DEV_MODE", getenv('NODE_ENV') === 'development');
define("MAINDOMAIN", getenv('MAINDOMAIN'));

define("IMAGE_PATH", __DIR__ . '/../public/assets/images/');
define("FOLDER_URL", getSiteURL() . getenv('PATH_TO_IMAGES'));

// check frontend domain for CORS
header("Access-Control-Allow-Origin: " . getenv('FRONT_HOST'));
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Origin, X-CSRF-Token, X-AUTH-Token');
header('Access-Control-Expose-Headers: X-AUTH-Token, X-CSRF-Token');

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (IS_DEV_MODE === false) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}
$containerBuilder->useAnnotations(true);

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

/** @var bool $displayErrorDetails */
$displayErrorDetails = $container->get('settings')['displayErrorDetails'];

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
