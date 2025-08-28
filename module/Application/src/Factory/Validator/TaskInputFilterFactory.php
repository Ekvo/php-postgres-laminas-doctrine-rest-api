<?php

namespace Application\Factory\Validator;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Фабрика для создания экземпляра TaskInputFilter.
 * Реализует интерфейс FactoryInterface, чтобы интегрироваться с контейнером сервисов Laminas.
 * Извлекает конфигурацию из контейнера и передаёт её в конструктор валидатора.
 */
class TaskInputFilterFactory implements FactoryInterface
{
    /**
     * Фабричный метод, вызываемый контейнером для создания экземпляра TaskInputFilter.
     * Получает конфигурацию из общего массива настроек приложения по ключу 'task_input_filter'.
     *
     * @param ContainerInterface $container Контейнер зависимостей
     * @param string $requestedName Запрашиваемое имя сервиса
     * @param array|null $options Дополнительные опции
     * @return \Application\Validator\TaskInputFilter Новый экземпляр фильтра с переданной конфигурацией
     */
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