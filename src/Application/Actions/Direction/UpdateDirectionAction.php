<?php
declare(strict_types=1);

namespace App\Application\Actions\Direction;

use App\Domain\Direction\Persistence\DirectionRepository;
use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\Project\Service\ProjectFactory;
use App\Domain\Project\Service\ProjectService;
use App\Infrastructure\Direction\Model\Request\UpdateDirectionDTO;
use App\Infrastructure\Project\Model\Request\UpdateProjectDTO;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use App\Infrastructure\Project\Model\Request\AddProjectDTO;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class UpdateDirectionAction
 * @package App\Application\Actions\Direction
 */
class UpdateDirectionAction extends DirectionAction
{

    private UpdateDirectionDTO $updateDirectionDTO;

    public function __construct(
        LoggerInterface $logger,
        DirectionRepository $directionRepository,
        UpdateDirectionDTO $updateDirectionDTO
    )
    {
        parent::__construct($logger, $directionRepository);
        $this->updateDirectionDTO = $updateDirectionDTO;
    }

    /**
     * @return Response
     * @throws HttpBadRequestException
     * @throws Exception
     */
    protected function action(): Response
    {
        $directionId = (int) $this->resolveArg('id');
        $directionEntity = $this->directionRepository->find($directionId);
        $this->updateDirectionDTO->setData($this->getRequestContent());
        $directionEntity->setCommonValues($this->updateDirectionDTO, true);

        $this->directionRepository->save($directionEntity);

        $this->logger->info("Direction of id " . $directionEntity->getId() . " was updated.");

        return $this->respondWithData($this->buildResponseMessage('Direction was updated.'), 200);
    }
}
