<?php
declare(strict_types=1);

use App\Domain\User\Service\UserFactory;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserFactory::class => \DI\autowire(UserFactory::class),
    ]);
};
