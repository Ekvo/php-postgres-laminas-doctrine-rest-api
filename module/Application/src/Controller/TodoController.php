<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;

use Application\Contract\TaskInputFilterContract;
use Application\Contract\TaskServiceContract;
use Application\Exception\TaskRepositoryException;
use Application\Exception\TaskServiceException;
use Application\Exception\TaskInputFilterException;
use Application\Utils\JsonEncode;

class TodoController extends AbstractRestfulController
{
    private TaskServiceContract $taskService;
    private TaskInputFilterContract $inputFilter;

    public function __construct(
        TaskServiceContract     $taskService,
        TaskInputFilterContract $inputFilter
    )
    {
        $this->taskService = $taskService;
        $this->inputFilter = $inputFilter;
    }

    /**
     * POST /api/todo - Create a new task
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
                ['error' => 'internal error'],
                500
            );
        }
    }

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
                ['error' => 'internal error'],
                500
            );
        }
    }

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
                ['error' => 'internal error'],
                500
            );
        }
    }

    public function update($id, $data)
    {
        try {
            $task = $this->inputFilter->decode($data)->setId($id);

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