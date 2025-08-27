<?php

namespace Application\Service;

use Application\Contract\TaskServiceContract;
use Application\Contract\TaskRepositoryContract;

use Application\Entity\Task;
use Application\Entity\TaskResponse;
use Application\Entity\TaskListResponse;
use Application\Entity\MessageResponse;

use Application\Exception\TaskServiceException;

class TaskService implements TaskServiceContract
{
    private TaskRepositoryContract $taskRepository;

    public function __construct(TaskRepositoryContract $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(Task $task): MessageResponse
    {
        $id = $this->taskRepository->create($task);

        if (!$id)
            throw new TaskServiceException('service internal error', 500);

        return new MessageResponse('create_status');
    }

    public function getTaskById(int $id): TaskResponse
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            throw new TaskServiceException("not found", 404);
        }

        $taskResponse = new TaskResponse($task);

        return $taskResponse;
    }

    public function getListOfTasks(): TaskListResponse
    {
        $tasks = $this->taskRepository->getList();

        if (!$tasks) {
            throw new TaskServiceException("not found", 404);
        }

        $taskListResponse = new TaskListResponse($tasks);

        return  $taskListResponse;
    }

    public function updateTaskByID(Task $task): MessageResponse
    {
        $this->taskRepository->updateByID($task);

        return new MessageResponse('update_status');
    }

    public function deleteTaskByID(int $id): MessageResponse
    {
        $this->taskRepository->deleteByID($id);

        return new MessageResponse('delete_status');
    }
}