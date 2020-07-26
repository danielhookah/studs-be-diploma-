<?php

namespace App\Domain\Services;

use App\Domain\User\UserEntity;
use App\Infrastructure\Shared\Exception\SendEmailException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Log\LoggerInterface;

/**
 * Class AccessService
 * @package App\Domain\Services
 */
class AccessService extends Service
{
    protected static UserEntity $user;

    /**
     * @param UserEntity $user
     */
    public static function setUser(UserEntity $user)
    {
        static::$user = $user;
    }

    /**
     * @return UserEntity
     */
    public static function getUser(): UserEntity
    {
        return static::$user;
    }

    /**
     * @return int
     */
    public static function getUserRole(): int
    {
        return static::$user->getRole();
    }
}
