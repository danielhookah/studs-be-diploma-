<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use phpDocumentor\Reflection\DocBlockFactory;
use function DI\factory;

abstract class AbstractEntityRepository implements AbstractEntityRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var QueryBuilder
     */
    protected QueryBuilder $queryBuilder;

    /**
     * @var ObjectRepository
     */
    protected ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function persist($object): void
    {
        $this->entityManager->persist($object);
    }

    public function persistMany(iterable $objects): void
    {
        foreach ($objects as $object) {
            $this->persist($object);
        }
    }

    public function save($object): void
    {
        $this->persist($object);
        $this->flush();
    }

    public function remove($object): void
    {
        $this->entityManager->remove($object);
    }

    public function removeImmediately($object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}