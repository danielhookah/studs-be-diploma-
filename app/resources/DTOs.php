<?php
declare(strict_types=1);

use App\Infrastructure\Project\Model\Request\AddProjectDTO;
use App\Infrastructure\Project\Model\Request\UpdateProjectDTO;
use App\Infrastructure\User\Model\Request\AddUserDTO;
use App\Infrastructure\User\Model\Request\UpdateUserDTO;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        // user
        AddUserDTO::class => \DI\autowire(AddUserDTO::class),
        UpdateUserDTO::class => \DI\autowire(UpdateUserDTO::class),
        // project
        AddProjectDTO::class => \DI\autowire(AddProjectDTO::class),
        UpdateProjectDTO::class => \DI\autowire(UpdateProjectDTO::class),
    ]);
};

// Serialise
// https://www.pmg.com/blog/trading-symfonys-form-component-for-data-transfer-objects/?cn-reloaded=1
// https://github.com/api-platform/core/issues/3066
// https://symfony.com/doc/current/components/serializer.html