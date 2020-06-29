<?php

$dbConfigConnectionOptions = [
    'driver' => 'pdo_mysql',
    'path' => 'database.mysql',
    'host' => getenv('DB_HOST'),
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASS'),
    'charset' => 'UTF8'
];