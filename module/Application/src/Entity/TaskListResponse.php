<?php

namespace Application\Entity;

/**
 * Класс-сущность для представления списка задач в формате ответа API.
 * Содержит массив объектов TaskResponse, готовых к передаче клиенту.
 */
class TaskListResponse
{
    /**
     * Список задач в формате ответа API
     * @var array<TaskResponse>
     */
    public array $listOfTasks = [];

    /**
     * Конструктор, инициализирующий список задач.
     * Преобразует массив сущностей Task в массив объектов TaskResponse.
     *
     * @param array $tasks Массив объектов Application\Entity\Task
     */
    public function __construct(array $tasks)
    {
        foreach ($tasks as $task) {
            $this->listOfTasks[] = new TaskResponse($task);
        }
    }
}