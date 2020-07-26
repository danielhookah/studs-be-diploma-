<?php

declare(strict_types=1);

namespace App\Domain\Project\Service;

use App\Domain\Project\Persistence\ProjectRepository;
use App\Domain\Project\ProjectEntity;
use App\Domain\ProjectUser\ProjectUserEntity;
use App\Domain\Services\AccessService;
use App\Domain\Services\ImageService;
use App\Domain\Services\Service;
use App\Infrastructure\Shared\Exception\CreateEntityException;
use Doctrine\ORM\EntityManagerInterface;
use PHPMailer\PHPMailer\Exception;
use Psr\Log\LoggerInterface;

/**
 * Class ProjectService
 * @package App\Domain\Project\Service
 */
class ProjectService extends Service
{
    private ImageService $imageService;
    private ProjectRepository $projectRepository;
    private ProjectEntity $project;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, ImageService $imageService)
    {
        parent::__construct($logger, $em);
        $this->imageService = $imageService;
    }

    /**
     * @param ProjectEntity $projectEntity
     * @return $this
     */
    public function setProject(ProjectEntity $projectEntity): ProjectService
    {
        $this->project = $projectEntity;
        return $this;
    }

    /**
     * @throws CreateEntityException
     */
    public function setCreator()
    {
        try {
            $projectUser = new ProjectUserEntity([
                'status' => 1,
                'project' => $this->project,
                'user' => AccessService::getUser()
            ]);
            $this->em->persist($projectUser);
            $this->project->getProjectUsers()->add($projectUser);
        } catch (\Exception $e) {
            throw new CreateEntityException("project user", 500, $e);
        }
    }

    /**
     * @param string|null $imgBase64
     * @return bool
     * @throws Exception
     */
    public function uploadImage(?string $imgBase64)
    {
        if ($imgBase64 === null || $this->imageService->checkIsImageUrl($imgBase64)) return false;

        try {
            $this->imageService->setMainName("project/" . $this->project->getId() . "/");
            $imageUrl = $this->imageService->base64ToImage($imgBase64, $this->project->getName());
            $this->project->setImage($imageUrl);
        } catch (\Exception $e) {
            $this->projectRepository->removeImmediately($this->project);
            throw new Exception('Can\'t upload image: ' . $e->getMessage());
        }

        return true;
    }
}
