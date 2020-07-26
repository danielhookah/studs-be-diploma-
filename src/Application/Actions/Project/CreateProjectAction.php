<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\Project\Service\ProjectFactory;
use App\Domain\Project\Service\ProjectService;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use App\Infrastructure\Project\Model\Request\AddProjectDTO;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class CreateProjectAction
 * @package App\Application\Actions\Project
 */
class CreateProjectAction extends ProjectAction
{

    private AddProjectDTO $addProjectDTO;
    private ProjectFactory $projectFactory;
    private ProjectService $projectService;

    public function __construct(
        LoggerInterface $logger,
        ProjectRepository $projectRepository,
        AddProjectDTO $addProjectDTO,
        ProjectFactory $projectFactory,
        ProjectService $projectService
    )
    {
        parent::__construct($logger, $projectRepository);
        $this->addProjectDTO = $addProjectDTO;
        $this->projectFactory = $projectFactory;
        $this->projectService = $projectService;
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
        $this->addProjectDTO->setData($this->getRequestContent());
        $dataDTO = $this->addProjectDTO->toArray();
        $image = array_key_exists('image', $dataDTO) ? array_pop($dataDTO) : null;

        // create & save project
        $projectEntity = $this->projectFactory->create($dataDTO);
        $this->projectService->setProject($projectEntity);
        $this->projectService->setCreator();
        $this->projectRepository->save($projectEntity);

        // upload & set image
        if ($this->projectService->uploadImage($image)) {
            $this->projectRepository->save($projectEntity);
        }

        $this->logger->info("Project of id " . $projectEntity->getId() . " was created.");

        return $this->respondWithData($this->buildResponseMessage('Project was created.'), 201);
    }
}
