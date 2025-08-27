<?php

namespace Application\Repository;

use Application\Contract\TaskRepositoryContract;
use Application\Entity\Task;
use Application\Exception\TaskRepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskRepository extends EntityRepository implements TaskRepositoryContract
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Task::class));
    }

    public function create(Task $task): int
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        return $task->getId();
    }

    public function findById(int $id): ?Task
    {
        $task = $this->find($id);

        if (!$task) {
            throw new TaskRepositoryException("not found", 404);
        }

        return $task;
    }

    public function getList(): array
    {
        return $this->findAll();
    }

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
                $e->getCode(),
                $e
            );
        }
    }
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