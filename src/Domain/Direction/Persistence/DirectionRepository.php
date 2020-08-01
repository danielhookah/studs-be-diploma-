<?php

declare(strict_types=1);

namespace App\Domain\Direction\Persistence;

use App\Domain\Direction\DirectionEntity;
use App\Infrastructure\Shared\Exception\ResourceNotFoundException;
use App\Infrastructure\Shared\Repository\AbstractEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ObjectRepository;
use Exception;

/**
 * Class DirectionRepository
 * @package App\Domain\Direction\Persistence
 */
class DirectionRepository extends AbstractEntityRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        /** @var ObjectRepository repository */
        $this->repository = $entityManager->getRepository(DirectionEntity::class);
    }

    /**
     * @param array $criteria
     *
     * @return DirectionEntity[]
     */
    public function findBy(array $criteria): array
    {
        /** @var DirectionEntity[] $directions */
        $directions = $this->repository->findBy($criteria);

        return $directions;
    }

    /**
     * @param array $criteria
     *
     * @return DirectionEntity|null
     * @throws ResourceNotFoundException
     */
    public function findOneBy(array $criteria): ?DirectionEntity
    {
        /** @var DirectionEntity|null $directionEntity */
        $directionEntity = $this->repository->findOneBy($criteria);
        if (!$directionEntity) {
            throw new ResourceNotFoundException('Direction with given criteria');
        }

        return $directionEntity;
    }

    /**
     * @param array $criteria
     *
     * @return DirectionEntity|null
     */
    public function findOneByOrNull(array $criteria): ?DirectionEntity
    {
        /** @var DirectionEntity|null $directionEntity */
        $directionEntity = $this->repository->findOneBy($criteria);
        return $directionEntity;
    }

    /**
     * @param int $directionId
     *
     * @return DirectionEntity|null
     * @throws ResourceNotFoundException
     */
    public function find(int $directionId): ?DirectionEntity
    {
        /** @var DirectionEntity|null $directionEntity */
        $directionEntity = $this->repository->find($directionId);
        if (!$directionEntity) {
            throw new ResourceNotFoundException('Direction with given id');
        }

        return $directionEntity;
    }

    /**
     * @param array $orderBy
     *
     * @return DirectionEntity[]
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

        $qb->select('direction')->from(DirectionEntity::class, 'direction');
        $qb->setFirstResult($firstResult)->setMaxResults($perPage);

        if ($filters['actualOnly']) {
            $qb->andWhere($qb->expr()->isNull('direction.deleted'));
        }

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
        $dataPrepared['directions'] = [];
        foreach ($paginator as $item) {
            $dataPrepared['directions'][] = $item;
        }

        return $dataPrepared;
    }
}