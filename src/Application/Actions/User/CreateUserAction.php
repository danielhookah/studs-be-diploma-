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
 * Class CreateUserAction
 * @package App\Application\Actions\User
 */
class CreateUserAction extends UserAction
{

    private AddUserDTO $addUserDTO;
    private UserFactory $userFactory;
    private UserService $userService;

    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository,
        AddUserDTO $addUserDTO,
        UserFactory $userFactory,
        UserService $userService
    )
    {
        parent::__construct($logger, $userRepository);
        $this->addUserDTO = $addUserDTO;
        $this->userFactory = $userFactory;
        $this->userService = $userService;
    }

    /**
     * @return Response
     * @throws CreateEntityException
     * @throws HttpBadRequestException
     * @throws Exception
     */
    protected function action(): Response
    {
        // set data from request & check it
        $this->addUserDTO->setData($this->getRequestContent());
        $dataDTO = $this->addUserDTO->toArray();
        $this->userService->checkUserUniq($dataDTO['email'], $dataDTO['phone']);
        // create & save user
        $userEntity = $this->userFactory->create($dataDTO);
        $this->userRepository->save($userEntity);
        $this->logger->info("User of id " . $userEntity->getId() . " was created.");
        // send email & return response
        $this->userService->sendConfirmEmail($userEntity);
        return $this->respondWithData($this->buildResponseMessage('User was created.'), 201);
    }
}
