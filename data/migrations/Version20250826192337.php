<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Миграция для создания таблицы задач и индекса к ней.
 * Загружает SQL-скрипты из файлов для операций вверх (up) и вниз (down).
 */
final class Version20250826192337 extends AbstractMigration
{
    /**
     * Описание миграции, отображаемое при выполнении команды.
     *
     * @return string Краткое описание изменений, вносимых миграцией
     */
    public function getDescription(): string
    {
        return 'Create tasks table, index from SQL file';;
    }

    /**
     * Применяет миграцию: создаёт таблицу задач и добавляет индекс.
     * Выполняет SQL-запросы из внешних файлов.
     *
     * @param Schema $schema Объект схемы базы данных
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->addSql(file_get_contents(__DIR__ . '/001_create_tasks_table.up.sql'));
        $this->addSql(file_get_contents(__DIR__ . '/002_create_tasks_table_index.up.sql'));
    }

    /**
     * Откатывает миграцию: удаляет индекс и таблицу задач.
     * Выполняет SQL-запросы из внешних файлов в обратном порядке.
     *
     * @param Schema $schema Объект схемы базы данных
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql(file_get_contents(__DIR__ . '/001_create_tasks_table_index.down.sql'));
        $this->addSql(file_get_contents(__DIR__ . '/002_create_tasks_table.down.sql'));
    }
}