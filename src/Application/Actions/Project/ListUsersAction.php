<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Persistence\UserRepository;
use App\Domain\User\UserEntity;
use App\Infrastructure\User\Model\Request\AddProjectDTO;
use App\Infrastructure\User\Model\Request\ResponseProjectDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ListUsersAction extends UserAction
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
        $data = $this->userRepository->createQueryBuilder(['perPage' => 3, 'firstResult' => 0])
            ->getPaginatedList();
        $data['users'] = array_map(function (UserEntity $user) {
            $responseUserDTO = new ResponseProjectDTO();
            $responseUserDTO->setData($user);

            return $responseUserDTO;
        }, $data['users']);

        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($data);
    }
}
