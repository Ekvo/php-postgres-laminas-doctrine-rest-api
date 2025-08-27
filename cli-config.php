<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$_ENV['DB_HOST'] = $_ENV['DB_HOST'] ?? '127.0.0.1';
$_ENV['DB_PORT'] = $_ENV['DB_PORT'] ?? '5432';
$_ENV['DB_USER'] = $_ENV['DB_USER'] ?? 'postgres';
$_ENV['DB_PASSWORD'] = $_ENV['DB_PASSWORD'] ?? '';
$_ENV['DB_NAME'] = $_ENV['DB_NAME'] ?? 'postgres';
$_ENV['DB_DRIVER'] = $_ENV['DB_DRIVER'] ?? 'pdo_pgsql';

$config = new PhpFile('migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders
$params = [
    'host'     => $_ENV['DB_HOST'],
    'port'     => $_ENV['DB_PORT'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'dbname'   => $_ENV['DB_NAME'],
    'driver'   => $_ENV['DB_DRIVER'],
];

$entityManager = EntityManager::create(
    $params,
    Setup::createAnnotationMetadataConfiguration(
        [__DIR__ . '/module/Application/src/Entity'],
        false, // isDevMode = false
        null,  // proxyDir
        null,  // cache
        false  // useSimpleAnnotationReader = FALSE (важно!)
    )
);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));