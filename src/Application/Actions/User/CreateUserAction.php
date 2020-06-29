<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Persistence\UserRepository;
use App\Domain\User\Service\UserFactory;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use App\Infrastructure\User\Model\Request\AddUserDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

/**
 * Class CreateUserAction
 * @package App\Application\Actions\User
 */
class CreateUserAction extends UserAction
{

    private AddUserDTO $addUserDTO;
    private UserFactory $userFactory;

    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository,
        AddUserDTO $addUserDTO,
        UserFactory $userFactory
    )
    {
        parent::__construct($logger, $userRepository);
        $this->addUserDTO = $addUserDTO;
        $this->userFactory = $userFactory;
    }

    /**
     * {@inheritdoc}
     * @throws CreateEntityException
     */
    protected function action(): Response
    {
        $this->addUserDTO->setData($this->getRequestContent());
        $userEntity = $this->userFactory->create($this->addUserDTO->toArray());
        $this->userRepository->save($userEntity);

        $this->logger->info("User of id " . $userEntity->getId() . " was created.");

        return $this->respondWithData($this->buildResponseMessage('User was created.'), 201);
    }
}
