<?php

namespace Application\Contract;

use Application\Entity\Task;
use Application\Entity\TaskResponse;
use Application\Entity\TaskListResponse;
use Application\Entity\MessageResponse;

/**
 * Контракт сервиса задач, определяющий бизнес-логику для работы с задачами.
 * Обеспечивает абстракцию над операциями создания, чтения, обновления и удаления задач.
 * Использует специализированные DTO-объекты для стандартизированного обмена данными между слоями приложения.
 */
interface TaskServiceContract
{
    /**
     * Создаёт новую задачу.
     *
     * @param Task $task Объект задачи с данными для создания
     * @return MessageResponse Ответ с информацией о результате операции
     */
    public function createTask(Task $task): MessageResponse;

    /**
     * Возвращает задачу по её идентификатору.
     *
     * @param int $id Идентификатор задачи
     * @return TaskResponse Ответ, содержащий объект задачи
     */
    public function getTaskById(int $id): TaskResponse;

    /**
     * Возвращает список всех задач.
     *
     * @return TaskListResponse Ответ, содержащий массив задач
     */
    public function getListOfTasks(): TaskListResponse;

    /**
     * Обновляет существующую задачу по её идентификатору.
     *
     * @param Task $task Объект задачи с обновлёнными данными
     * @return MessageResponse
     */
    public function updateTaskByID(Task $task): MessageResponse;

    /**
     * Удаляет задачу по её идентификатору.
     *
     * @param int $id Идентификатор задачи, которую необходимо удалить
     * @return MessageResponse
     */
    public function deleteTaskByID(int $id): MessageResponse;
}