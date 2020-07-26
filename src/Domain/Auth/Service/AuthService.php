<?php

declare(strict_types=1);

namespace App\Domain\Auth\Service;

use App\Domain\Services\MailService;
use App\Domain\Services\Service;
use App\Domain\User\Persistence\UserRepository;
use App\Domain\User\UserEntity;
use App\Infrastructure\Shared\Exception\ResourceNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * Class AuthService
 * @package App\Domain\Auth\Service
 */
class AuthService extends Service
{
    private UserRepository $userRepository;
    private MailService $mailService;
    private JwtAuth $jwtAuth;

    /**
     * AuthService constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     * @param UserRepository $userRepository
     * @param MailService $mailService
     * @param JwtAuth $jwtAuth
     */
    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        MailService $mailService,
        JwtAuth $jwtAuth
    )
    {
        parent::__construct($logger, $em);
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * @param string $email
     * @param string $password
     * @return UserEntity|null
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function authUser(string $email, string $password)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user->verifyPassword($password)) {
            throw new Exception('Email or password does not match', 401);
        }

        // Create a fresh token
        $token = $this->jwtAuth->createJwt([
            'uid' => $user->getEmail() . '-' . $user->getId(),
        ]);

//        $lifetime = $this->jwtAuth->getLifetime();
//        $result = [
//            'access_token' => $token,
//            'token_type' => 'Bearer',
//            'expires_in' => $lifetime,
//        ];

//        $_SESSION['user'] = json_encode($result);
        $_SESSION['userid'] = $user->getId();

        setcookie('authtoken', $token, time() + getenv('AUTH_TTL'), '/', '', false, true);
        setcookie('authl', '1', time() + getenv('AUTH_TTL'), '/', '', false, false);

        return $user;
    }

    public function logout()
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
            setcookie('authtoken', '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
            setcookie('authl', '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
