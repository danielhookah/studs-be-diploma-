<?php
declare(strict_types=1);

namespace App\Application\Actions\Direction;

use App\Domain\Direction\Persistence\DirectionRepository;
use App\Infrastructure\Direction\Model\Response\ResponseDirectionDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

/**
 * Class ViewDirectionAction
 * @package App\Application\Actions\Direction
 */
class ViewDirectionAction extends DirectionAction
{
    public function __construct(LoggerInterface $logger, DirectionRepository $directionRepository)
    {
        parent::__construct($logger, $directionRepository);
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $directionId = (int) $this->resolveArg('id');
        $params = $this->getQueryParams();

        $direction = $this->directionRepository->find($directionId);
        $data = $responseDirectionDTO = new ResponseDirectionDTO();
        $responseDirectionDTO->setData($direction, $params);

        $this->logger->info("Direction of id $directionId was viewed.");

        return $this->respondWithData($data->toArray());
    }
}
