<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;

use Application\Contract\TaskInputFilterContract;
use Application\Contract\TaskServiceContract;
use Application\Exception\TaskRepositoryException;
use Application\Exception\TaskServiceException;
use Application\Exception\TaskInputFilterException;
use Application\Utils\JsonEncode;

/**
 * REST-контроллер для управления задачами (TODO).
 * Обрабатывает HTTP-запросы на создание, получение, обновление и удаление задач.
 * Использует сервисный слой и фильтр ввода для обработки бизнес-логики и валидации данных.
 */
class TodoController extends AbstractRestfulController
{
    private TaskServiceContract $taskService;
    private TaskInputFilterContract $inputFilter;

    /**
     * Конструктор контроллера.
     * Инъекция зависимостей: сервис задач и фильтр входных данных.
     *
     * @param TaskServiceContract $taskService Сервис для выполнения бизнес-операций над задачами
     * @param TaskInputFilterContract $inputFilter Фильтр для валидации и преобразования входных данных
     */
    public function __construct(
        TaskServiceContract     $taskService,
        TaskInputFilterContract $inputFilter
    )
    {
        $this->taskService = $taskService;
        $this->inputFilter = $inputFilter;
    }

    /**
     * Обрабатывает POST-запрос для создания новой задачи.
     * Декодирует данные, переданные в теле запроса, создаёт задачу через сервис.
     *
     * @param array $data Данные новой задачи в формате массива
     * @return \Laminas\Stdlib\ResponseInterface JSON-ответ с результатом операции и статусом 201 при успехе
     */
    public function create($data)
    {
        try {
            $newTask = $this->inputFilter->decode($data);

            $message = $this->taskService->createTask($newTask);

            return JsonEncode::encode(
                $this->getResponse(),
                $message,
                201
            );
        } catch (TaskInputFilterException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskRepositoryException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskServiceException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (\Exception $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],//'internal error'],
                500
            );
        }
    }

    /**
     * Обрабатывает GET-запрос для получения задачи по ID.
     *
     * @param string|int $id Идентификатор задачи
     * @return \Laminas\Stdlib\ResponseInterface JSON-ответ с данными задачи или сообщением об ошибке
     */
    public function get($id)
    {
        try {
            $taskResponse = $this->taskService->getTaskById((int)$id);

            return JsonEncode::encode(
                $this->getResponse(),
                $taskResponse
            );
        } catch (TaskInputFilterException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskRepositoryException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskServiceException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (\Exception $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],//'internal error'],
                500
            );
        }
    }

    /**
     * Обрабатывает GET-запрос для получения списка всех задач.
     *
     * @return \Laminas\Stdlib\ResponseInterface JSON-ответ с массивом задач или сообщением об ошибке
     */
    public function getList()
    {
        try {
            $taskListResponse = $this->taskService->getListOfTasks();

            return JsonEncode::encode(
                $this->getResponse(),
                $taskListResponse->listOfTasks
            );
        } catch (TaskRepositoryException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskServiceException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (\Exception $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],//'internal error'],
                500
            );
        }
    }

    /**
     * Обрабатывает PUT-запрос для обновления задачи по ID.
     *
     * @param string|int $id Идентификатор задачи
     * @param array $data Обновлённые данные задачи
     * @return \Laminas\Stdlib\ResponseInterface JSON-ответ с результатом операции
     */
    public function update($id, $data)
    {
        try {
            $task = $this->inputFilter->decode($data)->setId((int)$id);

            $message = $this->taskService->updateTaskByID($task);

            return JsonEncode::encode(
                $this->getResponse(),
                $message
            );
        } catch (TaskInputFilterException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskRepositoryException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskServiceException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (\Exception $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],//'internal error'],
                500
            );
        }
    }

    /**
     * Обрабатывает DELETE-запрос для удаления задачи по ID.
     *
     * @param string|int $id Идентификатор задачи
     * @return \Laminas\Stdlib\ResponseInterface JSON-ответ с результатом операции
     */
    public function delete($id)
    {
        try {
            $message = $this->taskService->deleteTaskByID((int)$id);

            return JsonEncode::encode(
                $this->getResponse(),
                $message
            );
        } catch (TaskInputFilterException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskRepositoryException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (TaskServiceException $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        } catch (\Exception $e) {
            return JsonEncode::encode(
                $this->getResponse(),
                ['error' => $e->getMessage()],//'internal error'],
                500
            );
        }
    }
}