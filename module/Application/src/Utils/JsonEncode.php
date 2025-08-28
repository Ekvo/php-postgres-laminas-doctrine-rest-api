<?php

namespace Application\Utils;

use Laminas\Stdlib\ResponseInterface as Response;
use Laminas\Json\Json;

/**
 * Утилитарный класс для формирования JSON-ответов в HTTP-ответах.
 * Позволяет устанавливать статус, заголовки и содержимое ответа в формате JSON.
 */
class JsonEncode
{
    /**
     * Статический метод для кодирования данных в JSON и установки их в HTTP-ответ.
     * Устанавливает код состояния, заголовок Content-Type и содержимое ответа.
     *
     * @param Response $response Объект ответа, который будет модифицирован и возвращён
     * @param mixed $data Данные, которые необходимо преобразовать в JSON и отправить
     * @param int $statusCode HTTP-статус код ответа (по умолчанию 200)
     * @return Response Модифицированный объект ответа с JSON-содержимым и заголовками
     */
    public static function encode(
        Response $response,
                 $data,
                 $statusCode = 200
    ): Response
    {
        $response->setStatusCode($statusCode);
        $response->getHeaders()
            ->addHeaderLine(
                'Content-Type',
                'application/json; charset=utf-8'
            );
        $response->setContent(Json::encode($data));

        return $response;
    }
}