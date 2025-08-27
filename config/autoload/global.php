<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
$dotenv->load();

$_ENV['DB_HOST'] = $_ENV['DB_HOST'] ?? '127.0.0.1';
$_ENV['DB_PORT'] = $_ENV['DB_PORT'] ?? '5432';
$_ENV['DB_USER'] = $_ENV['DB_USER'] ?? 'postgres';
$_ENV['DB_PASSWORD'] = $_ENV['DB_PASSWORD'] ?? '';
$_ENV['DB_NAME'] = $_ENV['DB_NAME'] ?? 'postgres';
$_ENV['DB_DRIVER'] = $_ENV['DB_DRIVER'] ?? 'pdo_pgsql';
$_ENV['DB_CHARSET'] = $_ENV['DB_CHARSET'] ?? 'UTF8';

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'host' => $_ENV['DB_HOST'],
                    'port' => $_ENV['DB_PORT'],
                    'user' => $_ENV['DB_USER'],
                    'password' => $_ENV['DB_PASSWORD'],
                    'dbname' => $_ENV['DB_NAME'],
                    'driver' => $_ENV['DB_DRIVER'],
                    'charset' => $_ENV['DB_CHARSET'],
                ],
            ],
        ],
    ],
];
