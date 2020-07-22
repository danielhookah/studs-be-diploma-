<?php

declare(strict_types=1);

namespace App\Domain\Project\Persistence;

use App\Domain\Project\ProjectEntity;
use App\Infrastructure\Shared\Exception\ResourceNotFoundException;
use App\Infrastructure\Shared\Repository\AbstractEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ObjectRepository;
use Exception;

/**
 * Class ProjectRepository
 * @package App\Domain\Project\Persistence
 */
class ProjectRepository extends AbstractEntityRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        /** @var ObjectRepository repository */
        $this->repository = $entityManager->getRepository(ProjectEntity::class);
    }

    /**
     * @param array $criteria
     *
     * @return ProjectEntity[]
     */
    public function findBy(array $criteria): array
    {
        /** @var ProjectEntity[] $projects */
        $projects = $this->repository->findBy($criteria);

        return $projects;
    }

    /**
     * @param array $criteria
     *
     * @return ProjectEntity|null
     * @throws ResourceNotFoundException
     */
    public function findOneBy(array $criteria): ?ProjectEntity
    {
        /** @var ProjectEntity|null $projectEntity */
        $projectEntity = $this->repository->findOneBy($criteria);
        if (!$projectEntity) {
            throw new ResourceNotFoundException('Project with given criteria');
        }

        return $projectEntity;
    }

    /**
     * @param array $criteria
     *
     * @return ProjectEntity|null
     */
    public function findOneByOrNull(array $criteria): ?ProjectEntity
    {
        /** @var ProjectEntity|null $projectEntity */
        $projectEntity = $this->repository->findOneBy($criteria);
        return $projectEntity;
    }

    /**
     * @param int $projectId
     *
     * @return ProjectEntity|null
     * @throws ResourceNotFoundException
     */
    public function find(int $projectId): ?ProjectEntity
    {
        /** @var ProjectEntity|null $projectEntity */
        $projectEntity = $this->repository->find($projectId);
        if (!$projectEntity) {
            throw new ResourceNotFoundException('Project with given id');
        }

        return $projectEntity;
    }

    /**
     * @param array $orderBy
     *
     * @return ProjectEntity[]
     */
    public function findAll(array $orderBy = []): array
    {
        return $this->repository->findBy([], $orderBy);
    }

    /**
     * @param $params
     * @param bool $exceptionIfFalse
     * @return bool
     * @throws Exception
     */
    public function checkEntityExists($params, $exceptionIfFalse = false)
    {
        $result = !empty($this->findBy($params));

        if ($exceptionIfFalse && $result === false) {
            throw new Exception('Object does not exists', 400);
        }

        return $result;
    }

    // Query Builder

    /**
     * @param array $filters
     * @return $this
     */
    public function createQueryBuilder(array $filters)
    {
        $this->queryBuilder = $this->entityManager->createQueryBuilder();
        $qb = &$this->queryBuilder;

        $perPage = $filters['perPage'] ?? 10;
        $firstResult = $filters['firstResult'] ?? 0;

        $qb->select('project')->from(ProjectEntity::class, 'project');

        $qb->setFirstResult($firstResult)->setMaxResults($perPage);

        return $this;
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getPaginatedList()
    {
        if (empty($this->queryBuilder)) {
            throw new ResourceNotFoundException('QueryBuilder');
        }

        $dataPrepared = [];
        $paginator = new Paginator($this->queryBuilder->getQuery(), $fetchJoinCollection = true);
        $dataPrepared['count'] = count($paginator);
        $dataPrepared['projects'] = [];
        foreach ($paginator as $item) {
            $dataPrepared['projects'][] = $item;
        }

        return $dataPrepared;
    }
}