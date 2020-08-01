<?php
declare(strict_types=1);

namespace App\Application\Actions\Direction;

use App\Domain\Direction\Persistence\DirectionRepository;
use App\Domain\Direction\Service\DirectionFactory;
use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\Project\Service\ProjectFactory;
use App\Domain\Project\Service\ProjectService;
use App\Infrastructure\Direction\Model\Request\AddDirectionDTO;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class CreateDirectionAction
 * @package App\Application\Actions\Direction
 */
class CreateDirectionAction extends DirectionAction
{

    private AddDirectionDTO $addDirectionDTO;
    private ProjectService $projectService;
    private ProjectRepository $projectRepository;
    private DirectionFactory $directionFactory;

    public function __construct(
        LoggerInterface $logger,
        DirectionRepository $directionRepository,
        AddDirectionDTO $addDirectionDTO,
        ProjectRepository $projectRepository,
        ProjectService $projectService,
        DirectionFactory $directionFactory
    )
    {
        parent::__construct($logger, $directionRepository);
        $this->addDirectionDTO = $addDirectionDTO;
        $this->projectRepository = $projectRepository;
        $this->projectService = $projectService;
        $this->directionFactory = $directionFactory;
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
        $this->addDirectionDTO->setData($this->getRequestContent());
        $dataDTO = $this->addDirectionDTO->toArray();
        $dataDTO['project'] = $this->projectRepository->find(intval($dataDTO['project']['id']));

        // create & save direction
        $directionEntity = $this->directionFactory->create($dataDTO);
        $this->directionRepository->save($directionEntity);

        $this->logger->info("Direction of id " . $directionEntity->getId() . " was created.");

        return $this->respondWithData($this->buildResponseMessage('Direction was created.'), 201);
    }
}
