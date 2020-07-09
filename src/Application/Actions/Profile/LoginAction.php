<?php
declare(strict_types=1);

namespace App\Application\Actions\Profile;

use App\Application\Actions\User\UserAction;
use App\Domain\Auth\Service\AuthService;
use App\Domain\User\Persistence\UserRepository;
use App\Domain\User\Service\UserFactory;
use App\Domain\User\UserEntity;
use App\Infrastructure\User\Model\Request\ResponseUserDTO;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class LoginAction
 * @package App\Application\Actions\User\Profile
 */
class LoginAction extends UserAction
{

    private UserFactory $userFactory;
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
     * @throws HttpBadRequestException
     * @throws Exception
     */
    protected function action(): Response
    {
        list('email' => $email, 'password' => $password) = $this->getRequestContent();
        /** @var UserEntity $user */
        $user = $this->authService->authUser($email, $password);
        $responseUserDTO = new ResponseUserDTO();
        $responseUserDTO->setData($user);

        return $this->respondWithData($responseUserDTO->toArray(), 200);
    }
}
