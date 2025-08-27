-- Индекс для оптимизации поиска по дате создания
CREATE INDEX IF NOT EXISTS idx_tasks_created_at ON tasks(created_at DESC);