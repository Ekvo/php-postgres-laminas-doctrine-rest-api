<?php

namespace Application\Service;

use Application\Contract\TaskServiceContract;
use Application\Contract\TaskRepositoryContract;

use Application\Entity\Task;
use Application\Entity\TaskResponse;
use Application\Entity\TaskListResponse;
use Application\Entity\MessageResponse;

use Application\Exception\TaskServiceException;

/**
 * Сервисный класс, реализующий бизнес-логику для управления задачами.
 * Выполняет операции создания, получения, обновления и удаления задач,
 * используя репозиторий для взаимодействия с хранилищем данных.
 */
class TaskService implements TaskServiceContract
{
    /**
     * Репозиторий для выполнения операций с хранилищем задач
     * @var TaskRepositoryContract
     */
    private TaskRepositoryContract $taskRepository;

    /**
     * Конструктор сервиса.
     * Инъекция зависимости: репозиторий задач.
     *
     * @param TaskRepositoryContract $taskRepository Репозиторий для работы с данными задач
     */
    public function __construct(TaskRepositoryContract $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Создаёт новую задачу.
     *
     * @param Task $task Объект задачи, который необходимо сохранить
     * @return MessageResponse Сообщение об успешном создании
     * @throws TaskServiceException Если не удалось сохранить задачу
     */
    public function createTask(Task $task): MessageResponse
    {
        $id = $this->taskRepository->create($task);

        if (!$id)
            throw new TaskServiceException('service internal error', 500);

        return new MessageResponse('create_status');
    }

    /**
     * Возвращает задачу по её идентификатору.
     *
     * @param int $id Идентификатор задачи
     * @return TaskResponse Ответ с данными задачи
     * @throws TaskServiceException Если задача не найдена
     */
    public function getTaskById(int $id): TaskResponse
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            throw new TaskServiceException("not found", 404);
        }

        $taskResponse = new TaskResponse($task);

        return $taskResponse;
    }

    /**
     * Возвращает список всех задач.
     *
     * @return TaskListResponse Ответ, содержащий список задач
     * @throws TaskServiceException Если задачи не найдены
     */
    public function getListOfTasks(): TaskListResponse
    {
        $tasks = $this->taskRepository->getList();

        if (!$tasks) {
            throw new TaskServiceException("not found", 404);
        }

        $taskListResponse = new TaskListResponse($tasks);

        return  $taskListResponse;
    }

    /**
     * Обновляет существующую задачу по её идентификатору.
     *
     * @param Task $task Объект задачи с обновлёнными данными
     * @return MessageResponse Сообщение об успешном обновлении
     */
    public function updateTaskByID(Task $task): MessageResponse
    {
        $this->taskRepository->updateByID($task);

        return new MessageResponse('update_status');
    }

    /**
     * Удаляет задачу по её идентификатору.
     *
     * @param int $id Идентификатор задачи, которую необходимо удалить
     * @return MessageResponse Сообщение об успешном удалении
     */
    public function deleteTaskByID(int $id): MessageResponse
    {
        $this->taskRepository->deleteByID($id);

        return new MessageResponse('delete_status');
    }
}