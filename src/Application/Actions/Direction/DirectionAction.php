<?php
declare(strict_types=1);

namespace App\Application\Actions\Direction;

use App\Application\Actions\Action;
use App\Domain\Direction\Persistence\DirectionRepository;
use App\Domain\Project\Persistence\ProjectRepository;
use Psr\Log\LoggerInterface;

abstract class DirectionAction extends Action
{
    /**
     * @var DirectionRepository
     */
    protected DirectionRepository $directionRepository;

    /**
     * @param LoggerInterface $logger
     * @param DirectionRepository  $directionRepository
     */
    public function __construct(LoggerInterface $logger, DirectionRepository $directionRepository)
    {
        parent::__construct($logger);
        $this->directionRepository = $directionRepository;
    }
}
