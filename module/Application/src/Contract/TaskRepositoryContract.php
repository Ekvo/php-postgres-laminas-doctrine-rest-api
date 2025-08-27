<?php

namespace Application\Contract;

use Application\Entity\Task;

interface TaskRepositoryContract
{
    public function create(Task $task): int;
    public function findById(int $id): ?Task;

    public function getList(): array;

    public function updateByID(Task $task): void;

    public function deleteByID(int $id): void;

}