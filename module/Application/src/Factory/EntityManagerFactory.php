<?php

namespace Application\Factory;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Фабрика для создания Doctrine EntityManager
 * EntityManager - это основной объект для работы с базой данных через Doctrine ORM
 */
class EntityManagerFactory implements FactoryInterface
{
    /**
     * Метод, который вызывается контейнером зависимостей для создания EntityManager
     *
     * @param ContainerInterface $container Контейнер зависимостей Laminas
     * @param string $requestedName Имя запрашиваемого сервиса
     * @param array|null $options Дополнительные опции (обычно null)
     * @return EntityManager Возвращает настроенный EntityManager
     */
    public function __invoke(
        ContainerInterface $container,
                           $requestedName,
        array              $options = null
    )
    {
        // Получаем общую конфигурацию приложения
        $config = $container->get('config');

        // Извлекаем параметры подключения к базе данных из конфигурации Doctrine
        // Обычно содержит: driver, host, dbname, user, password, charset
        $dbParams = $config['doctrine']['connection']['orm_default']['params'];

        // Указываем пути, где Doctrine будет искать классы-сущности (Entity)
        // Эти классы представляют таблицы в базе данных
        $paths = [__DIR__ . '/../../src/Entity'];

        // Режим разработки:
        // true - включена отладка, кэширование отключено (для разработки)
        // false - кэширование включено (для production)
        $isDevMode = true;

        // Создаем конфигурацию Doctrine с использованием аннотаций
        // Аннотации - это PHP-комментарии с метаданными для сущностей
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration(
            $paths,          // Пути к классам-сущностям
            $isDevMode,      // Режим разработки
            null,            // Директория для proxy-классов (null = временная директория)
            null,            // Кэш (null = использовать ArrayCache в dev mode)
            false            // Важно: отключаем устаревший SimpleAnnotationReader
        );

        // Создаем и возвращаем EntityManager с параметрами БД и конфигурацией
        // EntityManager - основной объект для работы с БД: сохранение, обновление, удаление, запросы
        return EntityManager::create($dbParams, $doctrineConfig);
    }
}