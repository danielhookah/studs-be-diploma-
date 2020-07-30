<?php
declare(strict_types=1);

namespace App\Application\Actions\ProjectUser;

use App\Application\Actions\Action;
use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\User\Persistence\UserRepository;
use Psr\Log\LoggerInterface;

abstract class ProjectUserAction extends Action
{
    /**
     * @var ProjectRepository
     */
    protected ProjectRepository $projectRepository;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * ProjectUserAction constructor.
     *
     * @param LoggerInterface $logger
     * @param ProjectRepository $projectRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        LoggerInterface $logger,
        ProjectRepository $projectRepository,
        UserRepository $userRepository
    )
    {
        parent::__construct($logger);
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
    }
}
