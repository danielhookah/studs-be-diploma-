<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use _HumbugBox69342eed62ce\Nette\Utils\DateTime;
use App\Domain\User\UserEntity;
use App\Infrastructure\Shared\Exception\CreateEntityException;

/**
 * Class UserFactory
 * @package App\Domain\User\Service
 */
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
            $date = new DateTime();
            $hash = md5($initData['email'] . $initData['firstName'] . $initData['lastName']);
            $initData['confirmEmailHash'] = $hash . strval($date->getTimestamp());

            return new UserEntity($initData);
        } catch (\Exception $e) {
            throw new CreateEntityException("user", 500, $e);
        }
    }
}
