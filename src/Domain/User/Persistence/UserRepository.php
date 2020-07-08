<?php

declare(strict_types=1);

namespace App\Domain\User\Persistence;

use App\Domain\User\UserEntity;
use App\Infrastructure\Shared\Exception\ResourceNotFoundException;
use App\Infrastructure\Shared\Repository\AbstractEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ObjectRepository;
use Exception;

/**
 * Class UserRepository
 * @package App\Domain\User\Persistence
 */
class UserRepository extends AbstractEntityRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        /** @var ObjectRepository repository */
        $this->repository = $entityManager->getRepository(UserEntity::class);
    }

    /**
     * @param array $criteria
     *
     * @return UserEntity[]
     */
    public function findBy(array $criteria): array
    {
        /** @var UserEntity[] $users */
        $users = $this->repository->findBy($criteria);

        return $users;
    }

    /**
     * @param array $criteria
     *
     * @return UserEntity|null
     * @throws ResourceNotFoundException
     */
    public function findOneBy(array $criteria): ?UserEntity
    {
        /** @var UserEntity|null $userEntity */
        $userEntity = $this->repository->findOneBy($criteria);
        if (!$userEntity) {
            throw new ResourceNotFoundException('User with given criteria');
        }

        return $userEntity;
    }

    /**
     * @param array $criteria
     *
     * @return UserEntity|null
     */
    public function findOneByOrNull(array $criteria): ?UserEntity
    {
        /** @var UserEntity|null $userEntity */
        $userEntity = $this->repository->findOneBy($criteria);
        return $userEntity;
    }

    /**
     * @param int $userId
     *
     * @return UserEntity|null
     * @throws ResourceNotFoundException
     */
    public function find(int $userId): ?UserEntity
    {
        /** @var UserEntity|null $userEntity */
        $userEntity = $this->repository->find($userId);
        if (!$userEntity) {
            throw new ResourceNotFoundException('User with given id');
        }

        return $userEntity;
    }

    /**
     * @param array $orderBy
     *
     * @return UserEntity[]
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

        $qb->select('user')->from(UserEntity::class, 'user');

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
        $dataPrepared['users'] = [];
        foreach ($paginator as $item) {
            $dataPrepared['users'][] = $item;
        }

        return $dataPrepared;
    }
}