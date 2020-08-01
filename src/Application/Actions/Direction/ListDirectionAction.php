<?php
declare(strict_types=1);

namespace App\Application\Actions\Direction;

use App\Domain\Direction\DirectionEntity;
use App\Domain\Direction\Persistence\DirectionRepository;
use App\Infrastructure\Direction\Model\Response\ResponseDirectionDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

/**
 * Class ListDirectionAction
 * @package App\Application\Actions\Direction
 */
class ListDirectionAction extends DirectionAction
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
        $params = $this->getQueryParams();
        $data = $this->directionRepository->createQueryBuilder([
            'perPage' => $params['perPage'],
            'firstResult' => $params['firstResult'],
            'actualOnly' => true
        ])->getPaginatedList();

        $data['directions'] = array_map(function (DirectionEntity $direction) {
            $responseDirectionDTO = new ResponseDirectionDTO();
            $responseDirectionDTO->setData($direction);

            return $responseDirectionDTO;
        }, $data['directions']);

        $this->logger->info("Directions list was viewed.");

        return $this->respondWithData($data);
    }
}
