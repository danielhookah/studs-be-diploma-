<?php
declare(strict_types=1);

namespace App\Domain\User;

/**
 * Interface UserRepository
 * @package App\Domain\User
 */
interface UserRepository
{
    /**
     * @param int $userId
     * @return UserEntity|null
     */
    public function find(int $userId): ?UserEntity;

    /**
     * @return UserEntity[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return UserEntity
     */
    public function findUserOfId(int $id): UserEntity;
}
