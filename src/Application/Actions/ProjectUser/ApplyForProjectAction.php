<?php
declare(strict_types=1);

namespace App\Application\Actions\ProjectUser;

use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\Project\Service\ProjectService;
use App\Domain\ProjectUser\Service\ProjectUserFactory;
use App\Domain\User\Persistence\UserRepository;
use App\Infrastructure\ProjectUser\Model\Request\AddProjectUserDTO;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/**
 * Class ApplyForProjectAction
 * @package App\Application\Actions\ProjectUserAction
 */
class ApplyForProjectAction extends ProjectUserAction
{

    private AddProjectUserDTO $addProjectUserDTO;
    private ProjectService $projectService;
    private ProjectUserFactory $projectUserFactory;

    public function __construct(
        LoggerInterface $logger,
        ProjectUserFactory $projectUserFactory,
        ProjectRepository $projectRepository,
        UserRepository $userRepository,
        AddProjectUserDTO $addProjectUserDTO,
        ProjectService $projectService
    )
    {
        parent::__construct($logger, $projectRepository, $userRepository);
        $this->addProjectUserDTO = $addProjectUserDTO;
        $this->projectService = $projectService;
        $this->projectUserFactory = $projectUserFactory;
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
        $this->addProjectUserDTO->setData($this->getRequestContent());
        $dataDTO = $this->addProjectUserDTO->toArray();

        $dataDTO['project'] = $this->projectRepository->find($dataDTO['projectId']);
        $dataDTO['user'] = $this->userRepository->find($dataDTO['userId']);
        $this->projectService->checkProjectUserExists($dataDTO['user'], $dataDTO['project']);

        // create & save project user
        $projectEntity = $this->projectUserFactory->create($dataDTO);
        $this->projectRepository->save($projectEntity);

        $this->logger->info("Project user of id " . $projectEntity->getId() . " was created.");

        return $this->respondWithData($this->buildResponseMessage('User was applied for a Project.'), 201);
    }
}
