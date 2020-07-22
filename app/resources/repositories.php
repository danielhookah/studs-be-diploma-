<?php
declare(strict_types=1);

use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\User\Persistence\UserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(UserRepository::class),
    ]);
    $containerBuilder->addDefinitions([
        ProjectRepository::class => \DI\autowire(ProjectRepository::class),
    ]);
};
