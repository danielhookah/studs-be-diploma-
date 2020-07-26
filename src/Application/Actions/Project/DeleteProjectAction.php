<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\Project\Service\ProjectFactory;
use App\Domain\Project\Service\ProjectService;
use App\Infrastructure\Project\Model\Request\UpdateProjectDTO;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use App\Infrastructure\Project\Model\Request\AddProjectDTO;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class DeleteProjectAction
 * @package App\Application\Actions\Project
 */
class DeleteProjectAction extends ProjectAction
{

    private ProjectService $projectService;

    public function __construct(
        LoggerInterface $logger,
        ProjectRepository $projectRepository,
        ProjectService $projectService
    )
    {
        parent::__construct($logger, $projectRepository);
        $this->projectService = $projectService;
    }

    /**
     * @return Response
     * @throws HttpBadRequestException
     * @throws Exception
     */
    protected function action(): Response
    {
        $projectId = (int) $this->resolveArg('id');
        $projectEntity = $this->projectRepository->find($projectId);
//        $this->projectService->setProject($projectEntity);
        $projectEntity->setDeleted(new \DateTime());
        $this->projectRepository->save($projectEntity);

        $this->logger->info("Project of id " . $projectEntity->getId() . " was soft deleted.");

        return $this->respondWithData($this->buildResponseMessage('Project was deleted.'), 200);
    }
}
