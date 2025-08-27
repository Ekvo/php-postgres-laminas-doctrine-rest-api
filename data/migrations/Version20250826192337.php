<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250826192337 extends AbstractMigration
{
    public function getDescription(): string
    {
       return 'Create tasks table, index from SQL file';;
    }

    public function up(Schema $schema): void
    {
        $this->addSql(file_get_contents(__DIR__ . '/001_create_tasks_table.up.sql'));
        $this->addSql(file_get_contents(__DIR__ . '/002_create_tasks_table_index.up.sql'));
    }

    public function down(Schema $schema): void
    {
        $this->addSql(file_get_contents(__DIR__ . '/001_create_tasks_table_index.down.sql'));
        $this->addSql(file_get_contents(__DIR__ . '/002_create_tasks_table.down.sql'));
    }
}
