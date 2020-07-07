<?php

declare(strict_types=1);

namespace App\Domain\Services;

use Psr\Log\LoggerInterface;

abstract class Service {

    protected LoggerInterface $logger;

    /**
     * Service constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}