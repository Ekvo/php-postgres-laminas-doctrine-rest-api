<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Сущность Task - представляет задачу в системе
 *
 * @ORM\Entity
 * @ORM\Table(name="tasks") // Таблица в PostgreSQL будет называться "tasks"
 */
class Task
{
    /**
     * Уникальный идентификатор задачи
     * Стратегия IDENTITY для PostgreSQL использует SEQUENCE автоматически
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * Заголовок задачи
     *
     * @ORM\Column(type="string", length=255, name="title")
     */
    private $title;

    /**
     * Описание задачи
     *
     * @ORM\Column(type="text", name="description")
     */
    private $description;

    /**
     * Дата и время создания задачи
     * В PostgreSQL будет соответствовать типу TIMESTAMP
     *
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * Получить ID задачи
     *
     * @return int|null Идентификатор задачи или null, если не установлен
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Получить заголовок задачи
     *
     * @return string|null Заголовок задачи или null, если не установлен
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Получить описание задачи
     *
     * @return string|null Описание задачи или null, если не установлено
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Получить дату создания задачи
     *
     * @return DateTime|null Объект даты и времени или null, если не установлен
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Установить ID задачи
     *
     * @param int $id Идентификатор задачи
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Установить заголовок задачи
     *
     * @param string $title Заголовок задачи
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Установить описание задачи
     *
     * @param string $description Описание задачи
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Установить дату создания задачи
     *
     * @param string $date Строка даты в формате, понятном для DateTime
     * @return self
     */
    public function setCreatedAt(string $date): self
    {
        $this->createdAt = new DateTime($date);
        return $this;
    }
}