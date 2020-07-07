<?php
declare(strict_types=1);

$commons = require __DIR__ . '/resources/common.php';
$commons($containerBuilder);
$DTOs = require __DIR__ . '/resources/DTOs.php';
$DTOs($containerBuilder);
$repositories = require __DIR__ . '/resources/repositories.php';
$repositories($containerBuilder);
$factories = require __DIR__ . '/resources/factories.php';
$factories($containerBuilder);
$services = require __DIR__ . '/resources/services.php';
$services($containerBuilder);

