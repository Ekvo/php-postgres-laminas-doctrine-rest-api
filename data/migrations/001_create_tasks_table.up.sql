-- Создание таблицы tasks в PostgreSQL 11
CREATE TABLE IF NOT EXISTS tasks (
    id SERIAL PRIMARY KEY,                  -- Автоинкремент через SEQUENCE
    title VARCHAR(255) NOT NULL,            -- Заголовок задачи
    description TEXT NOT NULL,              -- Описание задачи
    created_at TIMESTAMP NOT NULL           -- Дата создания (TIMESTAMP для PostgreSQL)
    );

