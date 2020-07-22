<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Persistence\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class DeleteUserAction extends UserAction
{

    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository
    )
    {
        parent::__construct($logger, $userRepository);
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $userEntity = $this->userRepository->find($userId);
        $userEntity->setDeleted(new \DateTime());
        $this->userRepository->save($userEntity);

        $this->logger->info("User of id " . $userEntity->getId() . " was deleted.");

        return $this->respondWithData($this->buildResponseMessage('User was deleted.'), 200);
    }
}
