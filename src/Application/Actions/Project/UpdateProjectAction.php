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
 * Class UpdateProjectAction
 * @package App\Application\Actions\Project
 */
class UpdateProjectAction extends ProjectAction
{

    private UpdateProjectDTO $updateProjectDTO;
    private ProjectService $projectService;

    public function __construct(
        LoggerInterface $logger,
        ProjectRepository $projectRepository,
        UpdateProjectDTO $updateProjectDTO,
        ProjectService $projectService
    )
    {
        parent::__construct($logger, $projectRepository);
        $this->updateProjectDTO = $updateProjectDTO;
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
        $this->updateProjectDTO->setData($this->getRequestContent());
        $projectEntity->setCommonValues($this->updateProjectDTO, true);
        $this->projectService->setProject($projectEntity);

        // check image changed & upload & set image
        $dataDTO = $this->updateProjectDTO->toArray();
        $image = array_key_exists('image', $dataDTO) ? array_pop($dataDTO) : null;
        $this->projectService->uploadImage($image);

        $this->projectRepository->save($projectEntity);

        $this->logger->info("Project of id " . $projectEntity->getId() . " was updated.");

        return $this->respondWithData($this->buildResponseMessage('Project was updated.'), 200);
    }
}
