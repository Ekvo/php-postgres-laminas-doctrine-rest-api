<?php

namespace Application\Repository;

use Application\Contract\TaskRepositoryContract;
use Application\Entity\Task;
use Application\Exception\TaskRepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Репозиторий для работы с сущностью задачи (Task) в базе данных.
 * Реализует контракт TaskRepositoryContract и использует Doctrine ORM для доступа к данным.
 * Предоставляет методы для создания, чтения, обновления и удаления задач.
 */
class TaskRepository extends EntityRepository implements TaskRepositoryContract
{
    /**
     * Конструктор репозитория.
     * Инициализирует репозиторий с EntityManager и метаданными сущности Task.
     *
     * @param EntityManagerInterface $em Экземпляр EntityManager, управляющий сущностями
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Task::class));
    }

    /**
     * Сохраняет новую задачу в базе данных.
     *
     * @param Task $task Объект задачи, который необходимо сохранить
     * @return int Идентификатор вновь созданной задачи
     */
    public function create(Task $task): int
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        return $task->getId();
    }

    /**
     * Находит задачу по её идентификатору.
     *
     * @param int $id Уникальный идентификатор задачи
     * @return Task Возвращает объект задачи, если найден;
     * @throws TaskRepositoryException Если задача не найдена
     */
    public function findById(int $id): ?Task
    {
        $task = $this->find($id);

        if (!$task) {
            throw new TaskRepositoryException("not found", 404);
        }

        return $task;
    }

    /**
     * Возвращает список всех задач из базы данных.
     *
     * @return array Массив объектов Task (может быть пустым)
     */
    public function getList(): array
    {
        return $this->findAll();
    }

    /**
     * Обновляет существующую задачу по её идентификатору с помощью прямого SQL-запроса.
     * Использует DQL для точного контроля над операцией обновления.
     *
     * @param Task $task Объект задачи с обновлёнными данными
     * @return void
     * @throws TaskRepositoryException Если задача не найдена или произошла ошибка БД
     */
    public function updateByID(Task $task): void
    {
        try {
            $conn = $this->getEntityManager()->getConnection();

            $sql = 'UPDATE tasks 
                SET title = :title, 
                    description = :description, 
                    created_at = :created_at 
                WHERE id = :id 
                RETURNING id';

            $stmt = $conn->prepare($sql);
            $id = $stmt->executeQuery([
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'created_at' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
                'id' => $task->getId()
            ])->fetchAssociative();

            if (!$id) {
                throw new TaskRepositoryException('not found', 404);
            }

        } catch (\Exception $e) {
            throw new TaskRepositoryException(
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Удаляет задачу из базы данных по её идентификатору с помощью прямого SQL-запроса.
     * Использует RETURNING для проверки, была ли удалена запись.
     *
     * @param int $id Идентификатор задачи, которую необходимо удалить
     * @return void
     * @throws TaskRepositoryException Если задача не найдена или произошла ошибка БД
     */
    public function deleteById(int $id): void
    {
        try {
            $conn = $this->getEntityManager()->getConnection();

            $sql = 'DELETE FROM tasks WHERE id = :id RETURNING id';

            $stmt = $conn->prepare($sql);
            $id = $stmt->executeQuery(['id' => $id])
                ->fetchAssociative();

            if (!$id) {
                throw new TaskRepositoryException('not found', 404);
            }
        } catch (\Exception $e) {
            throw new TaskRepositoryException(
                $e->getMessage(),
                500,
            );
        }
    }
}