<?php

namespace Application\Entity;
class TaskResponse
{
    public int $id;
    public string $title;
    public string $description;
    public string $created_at;
    public function __construct(Task $task)
    {
        $this->id = $task->getId();
        $this->title = $task->getTitle();
        $this->description = $task->getDescription();
        $this->created_at = $task->getCreatedAt()->format('Y-m-d H:i:s');
    }
}

