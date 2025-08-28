<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Regex;
use Laminas\Router\Http\Segment;

return [
    /**
     * Маршруты приложения:
     * Определяют, какой контроллер и действие вызываются при обращении к определённому URL.
     */
    'router' => [
        'routes' => [
            // REST маршрут для Todo API
            'api-todo' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/todo[/:id]', // Поддержка /api/todo и /api/todo/{id}
                    'constraints' => [
                        'id' => '[1-9][0-9]*', // Ограничение: ID — положительное число
                    ],
                    'defaults' => [
                        'controller' => Controller\TodoController::class, // Контроллер для обработки запросов
                    ],
                ],
            ],
            // Маршрут для обработки 404 ошибок — ловит все неизвестные пути
            'not-found' => [
                'type' => Regex::class,
                'options' => [
                    'regex' => '/.*', // Соответствует любому пути
                    'defaults' => [
                        'controller' => Controller\ErrorController::class,
                        'action' => 'index',
                    ],
                    'spec' => '/', // Шаблон для генерации URL (не используется, так как маршрут только на чтение)
                ],
                'priority' => -1000, // Низкий приоритет — срабатывает, только если другие маршруты не подошли
            ],
        ],
    ],

    /**
     * Конфигурация контроллеров:
     * Определяет, как создаются экземпляры контроллеров.
     */
    'controllers' => [
        'factories' => [
            // Для TodoController используется фабрика, чтобы внедрить зависимости
            Controller\TodoController::class =>
                Factory\Controller\TodoControllerFactory::class,
        ],
        'invokables' => [
            // ErrorController не требует зависимостей — можно создавать напрямую
            Controller\ErrorController::class => Controller\ErrorController::class,
        ],
    ],

    /**
     * Конфигурация Service Manager:
     * Определяет, как создаются сервисы, используемые в приложении.
     */
    'service_manager' => [
        'factories' => [
            // Фабрика для EntityManager Doctrine
            'doctrine.entitymanager.orm_default' => Factory\EntityManagerFactory::class,

            // Регистрация репозитория задач
            \Application\Contract\TaskRepositoryContract::class =>
                function ($container) {
                    $entityManager = $container->get('doctrine.entitymanager.orm_default');
                    return new \Application\Repository\TaskRepository($entityManager);
                },

            // Регистрация сервиса задач
            \Application\Contract\TaskServiceContract::class =>
                function ($container) {
                    $taskRepository = $container->get(\Application\Contract\TaskRepositoryContract::class);
                    return new \Application\Service\TaskService($taskRepository);
                },

            // Регистрация фильтра ввода задач
            \Application\Contract\TaskInputFilterContract::class =>
                \Application\Factory\Validator\TaskInputFilterFactory::class,
        ],
    ],

    /**
     * Конфигурация фильтра ввода для сущности Task.
     * Определяет правила валидации и фильтрации для полей: title, description, created_at.
     */
    'task_input_filter' => [
        0 => [
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],  // Удаление пробелов по краям
                ['name' => 'StripTags'],   // Удаление HTML-тегов
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
                        'format' => 'Y-m-d H:i:s', // Ожидается формат даты
                    ]
                ]
            ]
        ]
    ],
];