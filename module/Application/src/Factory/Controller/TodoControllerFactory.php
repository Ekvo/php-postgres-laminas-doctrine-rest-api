<?php

namespace Application\Factory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

use Application\Controller\TodoController;

/**
 * Фабрика для создания экземпляра TodoController.
 * Реализует интерфейс FactoryInterface, чтобы интегрироваться с контейнером сервисов Laminas.
 * Инжектирует зависимости через контейнер: сервис задач и фильтр ввода.
 */
class TodoControllerFactory implements FactoryInterface
{
    /**
     * Фабричный метод, вызываемый контейнером для создания контроллера.
     * Извлекает необходимые зависимости из контейнера и передаёт их в конструктор контроллера.
     *
     * @param ContainerInterface $container Контейнер зависимостей
     * @param string $requestedName Запрашиваемое имя сервиса
     * @param array|null $options Дополнительные опции
     * @return TodoController Новый экземпляр контроллера с внедрёнными зависимостями
     */
    public function __invoke(
        ContainerInterface $container,
                           $requestedName,
        array              $options = null
    )
    {
        $taskService = $container->get(\Application\Contract\TaskServiceContract::class);
        $inputFilter = $container->get(\Application\Contract\TaskInputFilterContract::class);

        return new TodoController($taskService, $inputFilter);
    }
}