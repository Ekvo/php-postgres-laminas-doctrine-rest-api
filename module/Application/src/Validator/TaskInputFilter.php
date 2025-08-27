<?php

namespace Application\Validator;

use Laminas\InputFilter\InputFilter;

use Application\Entity\Task;
use Application\Contract\TaskInputFilterContract;

use Application\Exception\TaskInputFilterException;

class TaskInputFilter extends InputFilter implements TaskInputFilterContract
{
    public function __construct($filterConfig)
    {
        foreach ($filterConfig as $value) {
            $this->add($value);
        }
    }

    public function decode($data): Task
    {
        $this->checkCountFields($data);

        $this->setData($data);

        if (!$this->isValid())
            throw new TaskInputFilterException(
                $this->getMessages(),
                "invalid data",
                400
            );

        $validatedData = $this->getValues();

        $task = new Task();
        $task->setTitle($validatedData['title'])
            ->setDescription($validatedData['description'])
            ->setCreatedAt($validatedData['created_at']);

        return $task;
    }

    private function checkCountFields($data): void
    {
        if ($data === null)
            $data = [];

        if (count($data) > 3)
            throw new TaskInputFilterException([],"unknown fields", 400);
    }
}