<?php


namespace Application\Contract;

use Application\Entity\Task;

interface TaskInputFilterContract
{
    public function decode($data): Task;
}