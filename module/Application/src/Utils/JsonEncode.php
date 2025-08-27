<?php

namespace Application\Utils;

use Laminas\Stdlib\ResponseInterface as Response;
use Laminas\Json\Json;

class JsonEncode
{
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