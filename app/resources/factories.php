<?php
declare(strict_types=1);

use App\Domain\Direction\Service\DirectionFactory;
use App\Domain\Project\Service\ProjectFactory;
use App\Domain\ProjectUser\Service\ProjectUserFactory;
use App\Domain\User\Service\UserFactory;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserFactory::class => \DI\autowire(UserFactory::class),
        ProjectFactory::class => \DI\autowire(ProjectFactory::class),
        ProjectUserFactory::class => \DI\autowire(ProjectUserFactory::class),
        DirectionFactory::class => \DI\autowire(DirectionFactory::class),
    ]);
};
