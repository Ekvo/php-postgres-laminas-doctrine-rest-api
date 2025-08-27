<?php

namespace Application\Contract;

use Application\Entity\Task;
use Application\Entity\TaskResponse;
use Application\Entity\TaskListResponse;
use Application\Entity\MessageResponse;
interface TaskServiceContract
{
    public function createTask(Task $task): MessageResponse;
    public function getTaskById(int $id): TaskResponse;

    public function getListOfTasks(): TaskListResponse;
    public function updateTaskByID(Task $task): MessageResponse;
    public function deleteTaskByID(int $id): MessageResponse;
}
