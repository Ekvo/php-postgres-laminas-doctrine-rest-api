<?php

namespace Application\Validator;

use Laminas\InputFilter\InputFilter;

use Application\Entity\Task;
use Application\Contract\TaskInputFilterContract;

use Application\Exception\TaskInputFilterException;

/**
 * Валидатор и фильтр входных данных для задачи.
 * Проверяет и обрабатывает данные, полученные от пользователя, и преобразует их в объект Task.
 * Реализует контракт TaskInputFilterContract для стандартизации обработки ввода.
 */
class TaskInputFilter extends InputFilter implements TaskInputFilterContract
{
    /**
     * Конструктор, который инициализирует фильтр ввода, добавляя в него конфигурацию полей.
     *
     * @param array $filterConfig Конфигурация полей ввода (имя, валидаторы, фильтры и т.д.)
     */
    public function __construct($filterConfig)
    {
        foreach ($filterConfig as $value) {
            $this->add($value);
        }
    }

    /**
     * Преобразует и валидирует входные данные, возвращая объект Task при успешной проверке.
     * Если данные невалидны или содержат лишние поля — выбрасывает исключение.
     *
     * @param array $data Входные данные для валидации
     * @return Task Новый экземпляр задачи с валидированными данными
     * @throws TaskInputFilterException При ошибках валидации или наличии неизвестных полей
     */
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

    /**
     * Проверяет количество полей во входных данных.
     * Если передано более трёх полей (title, description, created_at), считает это ошибкой.
     *
     * @param array|null $data Массив входных данных
     * @return void
     * @throws TaskInputFilterException Если количество полей превышает допустимое
     */
    private function checkCountFields($data): void
    {
        if ($data === null)
            $data = [];

        if (count($data) > 3)
            throw new TaskInputFilterException([],"unknown fields", 400);
    }
}