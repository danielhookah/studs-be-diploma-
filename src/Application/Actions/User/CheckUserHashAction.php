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
//        return $this->respondWithData(['id' => 16], 200);
        $hash = $this->resolveArg('hash');
        $user = $this->userRepository->findOneBy(['confirmEmailHash' => $hash]);
        $result = $this->userService->checkHashActual($hash);

        if ($result === false) {
            return $this->respondWithData($this->buildResponseMessage('Hash is not actual.'), 400);
        }

        return $this->respondWithData(['id' => $user->getId()], 200);
    }
}
