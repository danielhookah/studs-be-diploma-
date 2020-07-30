<?php

declare(strict_types=1);

namespace App\Domain\ProjectUser\Service;

use App\Domain\Project\ProjectEntity;
use App\Domain\ProjectUser\ProjectUserEntity;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use DateTime;

/**
 * Class ProjectUserFactory
 * @package App\Domain\ProjectUser\Service
 */
class ProjectUserFactory
{
    /**
     * @param array $initData
     * @return ProjectUserEntity
     * @throws CreateEntityException
     */
    public function create(array $initData = []): ProjectUserEntity
    {
        try {
            return new ProjectUserEntity($initData);
        } catch (\Exception $e) {
            throw new CreateEntityException("project user", 500, $e);
        }
    }
}
