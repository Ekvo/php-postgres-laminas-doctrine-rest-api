<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Regex;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            // REST маршрут для Todo API
            'api-todo' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/todo[/:id]',
                    'constraints' => [
                        'id' => '[1-9][0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\TodoController::class,
                    ],
                ],
            ],
            // маршрут для 404 ошибок
            'not-found' => [
                'type' => Regex::class,
                'options' => [
                    'regex' => '/.*',
                    'defaults' => [
                        'controller' => Controller\ErrorController::class,
                        'action' => 'index',
                    ],
                    'spec' => '/',
                ],
                'priority' => -1000,
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>
                InvokableFactory::class,
            Controller\TodoController::class =>
                Factory\Controller\TodoControllerFactory::class,
        ],
        'invokables' => [
            Controller\ErrorController::class => Controller\ErrorController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'doctrine.entitymanager.orm_default' => Factory\EntityManagerFactory::class,
            \Application\Contract\TaskRepositoryContract::class =>
                function ($container) {
                    $entityManager = $container->get('doctrine.entitymanager.orm_default');
                    return new \Application\Repository\TaskRepository($entityManager);
                },
            \Application\Contract\TaskServiceContract::class =>
                function ($container) {
                    $taskRepository = $container->get(\Application\Contract\TaskRepositoryContract::class);
                    return new \Application\Service\TaskService($taskRepository);
                },
            \Application\Contract\TaskInputFilterContract::class =>
                \Application\Factory\Validator\TaskInputFilterFactory::class,
        ],
    ],
    'task_input_filter' => [
        0 => [
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 255,
                    ]
                ]
            ]
        ],
        1 => [
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 2048,
                    ]
                ]
            ]
        ],
        2 => [
            'name' => 'created_at',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Date',
                    'options' => [
                        'format' => 'Y-m-d H:i:s',
                    ]
                ]
            ]
        ]
    ],
];
