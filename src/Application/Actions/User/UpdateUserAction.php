<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Persistence\UserRepository;
use App\Infrastructure\User\Model\Request\UpdateUserDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class UpdateUserAction extends UserAction
{

    private UpdateUserDTO $updateUserDTO;

    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository,
        UpdateUserDTO $updateUserDTO
    )
    {
        parent::__construct($logger, $userRepository);
        $this->updateUserDTO = $updateUserDTO;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $userEntity = $this->userRepository->find($userId);
        $this->updateUserDTO->setData($this->getRequestContent());
        $userEntity->setCommonValues($this->updateUserDTO, true);
        $this->userRepository->save($userEntity);

        $this->logger->info("User of id " . $userEntity->getId() . " was updated.");

        return $this->respondWithData($this->buildResponseMessage('User was updated.'), 200);
    }
}
