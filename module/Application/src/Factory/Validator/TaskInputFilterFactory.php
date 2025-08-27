<?php

namespace Application\Factory\Validator;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class TaskInputFilterFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
                           $requestedName,
        array              $options = null
    )
    {
        $config = $container->get('Config');
        $filterConfig = $config['task_input_filter'] ?? [];

        return new \Application\Validator\TaskInputFilter($filterConfig);
    }
}