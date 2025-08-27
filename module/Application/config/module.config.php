<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
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
            ]
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
    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>
                InvokableFactory::class,
            Controller\TodoController::class =>
                Factory\Controller\TodoControllerFactory::class,
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
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
