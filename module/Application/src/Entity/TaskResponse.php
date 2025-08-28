<?php

namespace Application\Entity;

/**
 * Класс-сущность для представления данных задачи в формате ответа API.
 * Используется для передачи информации о задаче клиенту в стандартизированной структуре.
 */
class TaskResponse
{
    /**
     * Уникальный идентификатор задачи
     * @var int
     */
    public int $id;

    /**
     * Заголовок задачи
     * @var string
     */
    public string $title;

    /**
     * Описание задачи
     * @var string
     */
    public string $description;

    /**
     * Дата и время создания задачи в формате 'Y-m-d H:i:s'
     * @var string
     */
    public string $created_at;

    /**
     * Конструктор, инициализирующий объект на основе сущности Task.
     *
     * @param Task $task Объект задачи, данные из которого копируются в ответ
     */
    public function __construct(Task $task)
    {
        $this->id = $task->getId();
        $this->title = $task->getTitle();
        $this->description = $task->getDescription();
        $this->created_at = $task->getCreatedAt()->format('Y-m-d H:i:s');
    }
}