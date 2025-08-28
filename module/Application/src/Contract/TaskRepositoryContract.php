<?php

namespace Application\Contract;

use Application\Entity\Task;

/**
 * Контракт репозитория для управления сущностями задач (Task).
 * Определяет набор методов для выполнения CRUD-операций над задачами.
 * Абстрагирует реализацию хранения и получения данных о задачах.
 */
interface TaskRepositoryContract
{
    /**
     * Сохраняет новую задачу в хранилище.
     *
     * @param Task $task Объект задачи, который необходимо сохранить
     * @return int Идентификатор вновь созданной задачи
     */
    public function create(Task $task): int;

    /**
     * Находит задачу по её идентификатору.
     *
     * @param int $id Уникальный идентификатор задачи
     * @return Task|null Возвращает объект задачи, если найден; иначе — null
     */
    public function findById(int $id): ?Task;

    /**
     * Возвращает список всех задач из хранилища.
     *
     * @return array Массив объектов Task (может быть пустым)
     */
    public function getList(): array;

    /**
     * Обновляет существующую задачу по её идентификатору.
     *
     * @param Task $task Объект задачи с обновлёнными данными
     * @return void
     */
    public function updateByID(Task $task): void;

    /**
     * Удаляет задачу из хранилища по её идентификатору.
     *
     * @param int $id Идентификатор задачи, которую необходимо удалить
     * @return void
     */
    public function deleteByID(int $id): void;
}