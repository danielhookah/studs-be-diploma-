<?php
declare(strict_types=1);

use App\Application\Actions\Profile\GetCsrfTokenAction;
use App\Application\Actions\Profile\LogoutAction;
use App\Application\Actions\Project\CreateProjectAction;
use App\Application\Actions\User\CheckUserHashAction;
use App\Application\Actions\User\ConfirmUserAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\Profile\LoginAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Middleware\JwtAuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\Csrf\CsrfMiddleware;
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

    $app->group('/api', function (Group $api) use ($app) {
        // user
        $api->group('/user', function (Group $user) {
            $user->get('[/{{filters}}]', ListUsersAction::class);

            $user->get('/{id}', ViewUserAction::class);
            $user->post('[/]', CreateUserAction::class);
            $user->put('/{id}', UpdateUserAction::class);
            $user->delete('/{id}', DeleteUserAction::class);

            $user->get('/check-hash-actual/{hash}', CheckUserHashAction::class);
            $user->put('/{id}/confirm[/]', ConfirmUserAction::class);
        })->add($app->getContainer()->get(JwtAuthMiddleware::class));

        // profile
        $api->group('/profile', function (Group $profile) use ($app) {
//            $profile->get('[/]', ViewUserAction::class);
            $profile->get('/csrf-token[/]', GetCsrfTokenAction::class);
            $profile->post('/login[/]', LoginAction::class);
            $profile->post('/logout[/]', LogoutAction::class)
                ->add($app->getContainer()->get(JwtAuthMiddleware::class));
        });

        // project
        $api->group('/project', function (Group $project) {
//            $project->get('[/{{filters}}]', ListUsersAction::class);

//            $project->get('/{id}', ViewUserAction::class);
            $project->post('[/]', CreateProjectAction::class);
//            $project->put('/{id}', UpdateUserAction::class);
//            $project->delete('/{id}', DeleteUserAction::class);
        })->add($app->getContainer()->get(JwtAuthMiddleware::class));

    })->add($app->getContainer()->get(CsrfMiddleware::class));
};
