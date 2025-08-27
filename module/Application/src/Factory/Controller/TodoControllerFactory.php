<?php

namespace Application\Factory\Controller;

use Application\Controller\TodoController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class TodoControllerFactory implements FactoryInterface
{
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