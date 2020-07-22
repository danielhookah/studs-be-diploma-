<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Persistence\UserRepository;
use App\Infrastructure\User\Model\Request\ResponseProjectDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ViewUserAction extends UserAction
{

    public function __construct(LoggerInterface $logger, UserRepository $userRepository)
    {
        parent::__construct($logger, $userRepository);
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->userRepository->find($userId);
        $data = $responseUserDTO = new ResponseProjectDTO();
        $responseUserDTO->setData($user);

        $this->logger->info("User of id `${userId}` was viewed.");

        return $this->respondWithData($data);
    }
}
