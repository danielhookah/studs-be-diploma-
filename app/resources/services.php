<?php
declare(strict_types=1);

use App\Domain\Project\Service\ProjectService;
use App\Domain\Services\ImageService;
use App\Domain\Services\MailService;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        MailService::class => \DI\autowire(MailService::class),
        ImageService::class => \DI\autowire(ImageService::class),
        ProjectService::class => \DI\autowire(ProjectService::class),
    ]);
};
