<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\Project\ProjectEntity;
use App\Domain\User\UserEntity;
use App\Infrastructure\Project\Model\Response\ResponseProjectDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ListProjectsAction extends ProjectAction
{

    public function __construct(LoggerInterface $logger, ProjectRepository $projectRepository)
    {
        parent::__construct($logger, $projectRepository);
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $params = $this->getQueryParams();
        $data = $this->projectRepository->createQueryBuilder([
            'perPage' => $params['perPage'],
            'firstResult' => $params['firstResult'],
            'actualOnly' => true
        ])->getPaginatedList();

        $data['projects'] = array_map(function (ProjectEntity $project) {
            $responseUserDTO = new ResponseProjectDTO();
            $responseUserDTO->setData($project);

            return $responseUserDTO;
        }, $data['projects']);

        $this->logger->info("Projects list was viewed.");

        return $this->respondWithData($data);
    }
}
