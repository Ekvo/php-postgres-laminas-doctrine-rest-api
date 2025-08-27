-- Удаление индекса и таблицы tasks при откате миграции
DROP INDEX IF EXISTS idx_tasks_created_at;