<?php

declare(strict_types=1);

namespace App\Domain\Direction\Service;

use App\Domain\Direction\DirectionEntity;
use App\Domain\Project\ProjectEntity;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use DateTime;

/**
 * Class DirectionFactory
 * @package App\Domain\Direction\Service
 */
class DirectionFactory
{
    /**
     * @param array $initData
     * @return DirectionEntity
     * @throws CreateEntityException
     */
    public function create(array $initData = []): DirectionEntity
    {
        try {
            return new DirectionEntity($initData);
        } catch (\Exception $e) {
            throw new CreateEntityException("direction", 500, $e);
        }
    }
}
