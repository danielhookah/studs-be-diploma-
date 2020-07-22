<?php

declare(strict_types=1);

namespace App\Domain\Project\Service;

use App\Domain\Project\ProjectEntity;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use DateTime;

/**
 * Class ProjectFactory
 * @package App\Domain\Project\Service
 */
class ProjectFactory
{
    /**
     * @param array $initData
     * @return ProjectEntity
     * @throws CreateEntityException
     */
    public function create(array $initData = []): ProjectEntity
    {
        try {
            return new ProjectEntity($initData);
        } catch (\Exception $e) {
            throw new CreateEntityException("project", 500, $e);
        }
    }
}
