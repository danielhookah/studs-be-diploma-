<?php

declare(strict_types=1);

namespace App\Domain\Services;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

abstract class Service {

    protected LoggerInterface $logger;
    protected EntityManagerInterface $em;

    /**
     * Service constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->em = $em;
    }
}