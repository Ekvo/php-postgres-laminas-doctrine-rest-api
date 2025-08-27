<?php

namespace Application\Entity;

class TaskListResponse
{
    public array $listOfTasks = [];
    public function __construct(array $tasks)
    {
        foreach ($tasks as $task) {
            $this->listOfTasks[] = new TaskResponse($task);
        }
    }
}
