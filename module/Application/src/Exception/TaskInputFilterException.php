<?php

namespace Application\Exception;

use Throwable;

/**
 * Исключение, выбрасываемое при ошибках валидации или фильтрации входных данных задачи.
 * Содержит дополнительный массив ошибок, детализирующий проблемы с вводом.
 */
class TaskInputFilterException extends \Exception
{
    /**
     * Массив ошибок, связанных с валидацией входных данных
     * @var array
     */
    private array $errArr;

    /**
     * Конструктор исключения.
     *
     * @param array $errArr Массив с детализацией ошибок валидации
     * @param string $message Сообщение об ошибке
     * @param int $code Код ошибки
     * @param Throwable|null $previous Предыдущее исключение (при цепочке исключений)
     */
    public function __construct(
        array $errArr,
              $message = "",
              $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->errArr = $errArr;
    }

    /**
     * Возвращает массив ошибок валидации, связанных с этим исключением.
     *
     * @return array Массив с детализацией ошибок
     */
    public function getErrArr(): array
    {
        return $this->errArr;
    }
}