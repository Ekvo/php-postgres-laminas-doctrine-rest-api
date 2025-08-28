<?php

declare(strict_types=1);

namespace Application;

/**
 * Класс модуля, представляющий модуль Application в приложении Laminas.
 * Отвечает за загрузку конфигурации модуля, включая настройки сервисов, маршрутов, контроллеров и других компонентов.
 */
class Module
{
    /**
     * Возвращает конфигурацию модуля.
     * Загружает конфигурацию из внешнего файла и возвращает её в виде массива.
     *
     * @return array Массив конфигурации модуля
     */
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}