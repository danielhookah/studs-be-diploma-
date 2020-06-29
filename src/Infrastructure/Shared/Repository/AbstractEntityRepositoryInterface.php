<?php

namespace App\Infrastructure\Shared\Repository;

interface AbstractEntityRepositoryInterface
{
    public function flush(): void;

    public function persist($object): void;

    public function persistMany(iterable $objects): void;

    public function save($object): void;

    public function remove($object): void;

    public function removeImmediately($object): void;
}