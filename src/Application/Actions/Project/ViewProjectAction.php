<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use App\Domain\Project\Persistence\ProjectRepository;
use App\Infrastructure\Project\Model\Response\ResponseProjectDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

/**
 * Class ViewProjectAction
 * @package App\Application\Actions\Project
 */
class ViewProjectAction extends ProjectAction
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
        $projectId = (int) $this->resolveArg('id');
        $params = $this->getQueryParams();

        $project = $this->projectRepository->find($projectId);
        $data = $responseProjectDTO = new ResponseProjectDTO();
        $responseProjectDTO->setData($project, $params);

        $this->logger->info("Project of id $projectId was viewed.");

        return $this->respondWithData($data->toArray());
    }
}
