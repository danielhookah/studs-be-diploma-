<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\UserEntity;
use App\Infrastructure\Shared\Exception\CreateEntityException;

class UserFactory
{
    /**
     * @param array $initData
     * @return UserEntity
     * @throws CreateEntityException
     */
    public function create(array $initData = []): UserEntity
    {
        try {
            return new UserEntity($initData);
        } catch (\Exception $e) {
            throw new CreateEntityException("user", 500, $e);
        }
    }
}