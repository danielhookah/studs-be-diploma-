<?php

use Doctrine\ORM\EntityManagerInterface;

require_once "app/bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($container->get(EntityManagerInterface::class));