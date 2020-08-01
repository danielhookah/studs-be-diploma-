<?php
declare(strict_types=1);

use App\Application\Actions\Direction\CreateDirectionAction;
use App\Application\Actions\Direction\DeleteDirectionAction;
use App\Application\Actions\Direction\ListDirectionAction;
use App\Application\Actions\Direction\UpdateDirectionAction;
use App\Application\Actions\Direction\ViewDirectionAction;
use App\Application\Actions\Profile\GetCsrfTokenAction;
use App\Application\Actions\Profile\LogoutAction;
use App\Application\Actions\Project\CreateProjectAction;
use App\Application\Actions\Project\DeleteProjectAction;
use App\Application\Actions\Project\ListProjectsAction;
use App\Application\Actions\Project\UpdateProjectAction;
use App\Application\Actions\Project\ViewProjectAction;
use App\Application\Actions\ProjectUser\ApplyForProjectAction;
use App\Application\Actions\User\CheckUserHashAction;
use App\Application\Actions\User\ConfirmUserAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\Profile\LoginAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Middleware\JwtAuthMiddleware;
use App\Infrastructure\Direction\Model\Request\UpdateDirectionDTO;
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
        $api->post('/user[/]', CreateUserAction::class);
        $api->get('/user/check-hash-actual/{hash}', CheckUserHashAction::class);
        $api->put('/user/{id}/confirm[/]', ConfirmUserAction::class);
        $api->group('/user', function (Group $user) {
            $user->get('/list/[{filters}]', ListUsersAction::class);

            $user->get('/{id}', ViewUserAction::class);
            $user->put('/{id}', UpdateUserAction::class);
            $user->delete('/{id}', DeleteUserAction::class);

        })->add($app->getContainer()->get(JwtAuthMiddleware::class));

        // profile
        $api->group('/profile', function (Group $profile) use ($app) {
//            $profile->get('[/]', ViewUserAction::class);
            $profile->get('/csrf-token[/]', GetCsrfTokenAction::class);
            $profile->post('/login[/]', LoginAction::class);
            $profile->post('/logout[/]', LogoutAction::class);
        });

        // project
        $api->get('/project/list[{filters}]', ListProjectsAction::class);
        $api->get('/project/{id}', ViewProjectAction::class);
        $api->group('/project', function (Group $project) {

            $project->post('[/]', CreateProjectAction::class);
            $project->put('/{id}', UpdateProjectAction::class);
            $project->delete('/{id}', DeleteProjectAction::class);

            $project->post('/{id}/apply/{userId}', ApplyForProjectAction::class);
        })->add($app->getContainer()->get(JwtAuthMiddleware::class));

        // direction
        $api->get('/direction/list[{filters}]', ListDirectionAction::class);
        $api->get('/direction/{id}', ViewDirectionAction::class);
        $api->group('/direction', function (Group $direction) {

            $direction->post('[/]', CreateDirectionAction::class);
            $direction->put('/{id}', UpdateDirectionAction::class);
            $direction->delete('/{id}', DeleteDirectionAction::class);
        })->add($app->getContainer()->get(JwtAuthMiddleware::class));

    })->add($app->getContainer()->get(CsrfMiddleware::class));
};
