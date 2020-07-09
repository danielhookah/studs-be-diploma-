<?php
declare(strict_types=1);

use App\Application\Actions\User\CheckUserHashAction;
use App\Application\Actions\User\ConfirmUserAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello World!');
        return $response;
    });

    $app->group('/api', function (Group $api) {
        // user
        $api->group('/user', function (Group $user) {
            // [/{{filters}}]
            $user->get('[/{{filters}}]', ListUsersAction::class);

            $user->get('/{id}', ViewUserAction::class);
            $user->post('[/]', CreateUserAction::class);
            $user->put('/{id}', UpdateUserAction::class);
            $user->delete('/{id}', DeleteUserAction::class);

            $user->get('/check-hash-actual/{hash}', CheckUserHashAction::class);
            $user->put('/{id}/confirm[/]', ConfirmUserAction::class);
        });
        // email
//        $api->group('/email', function (Group $email) {
//            $email->get('/check-hash-relevance', ViewUserAction::class);
//        });

    });
};
