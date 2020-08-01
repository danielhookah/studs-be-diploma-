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
 * Class DeleteDirectionAction
 * @package App\Application\Actions\Direction
 */
class DeleteDirectionAction extends DirectionAction
{

    public function __construct(
        LoggerInterface $logger,
        DirectionRepository $directionRepository
    )
    {
        parent::__construct($logger, $directionRepository);
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
        $directionEntity->setDeleted(new \DateTime());
        $this->directionRepository->save($directionEntity);

        $this->logger->info("Direction of id " . $directionEntity->getId() . " was soft deleted.");

        return $this->respondWithData($this->buildResponseMessage('Direction was deleted.'), 200);
    }
}
