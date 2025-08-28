<?php

namespace Application\Entity;

/**
 * Класс-сущность для представления ответа с текстовым сообщением.
 * Используется для возврата статусных или информационных сообщений через API (например, результат операции).
 */
class MessageResponse
{
    /**
     * Текстовое сообщение, передаваемое в ответе
     * @var string
     */
    public string $message;

    /**
     * Конструктор для инициализации объекта сообщением.
     *
     * @param string $msg Текст сообщения
     */
    public function __construct(string $msg)
    {
        $this->message = $msg;
    }
}