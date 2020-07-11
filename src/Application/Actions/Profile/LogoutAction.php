<?php
declare(strict_types=1);

namespace App\Application\Actions\Profile;

use App\Application\Actions\User\UserAction;
use App\Domain\Auth\Service\AuthService;
use App\Domain\User\Persistence\UserRepository;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

/**
 * Class LogoutAction
 * @package App\Application\Actions\Profile
 */
class LogoutAction extends UserAction
{

    private AuthService $authService;

    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository,
        AuthService $authService
    )
    {
        parent::__construct($logger, $userRepository);
        $this->authService = $authService;
    }

    /**
     * @return Response
     * @throws Exception
     */
    protected function action(): Response
    {
        $this->authService->logout();
        return $this->respondWithData(null, 200);
    }
}