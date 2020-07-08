<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Persistence\UserRepository;
use App\Domain\User\Service\UserFactory;
use App\Domain\User\Service\UserService;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use App\Infrastructure\User\Model\Request\AddUserDTO;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class CheckUserHashAction
 * @package App\Application\Actions\User
 */
class CheckUserHashAction extends UserAction
{
    private UserService $userService;

    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository,
        UserService $userService
    )
    {
        parent::__construct($logger, $userRepository);
        $this->userService = $userService;
    }

    /**
     * @return Response
     * @throws Exception
     */
    protected function action(): Response
    {
        $hash = $this->resolveArg('hash');
        $result = $this->userService->checkHashActual($hash, 'confirmEmailHash');

        if ($result === false) {
            return $this->respondWithData($this->buildResponseMessage('Hash is not actual.'), 200);
        }

        return $this->respondWithData(null, 200);
    }
}
