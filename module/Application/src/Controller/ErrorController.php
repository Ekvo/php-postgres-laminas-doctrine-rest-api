<?php
// src/Controller/ErrorController.php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Application\Utils\JsonEncode;


/**
 * Контроллер для обработки ошибок в приложении.
 * Отвечает за возврат стандартизированного JSON-ответа при возникновении ошибки, например, 404.
 */
class ErrorController extends AbstractActionController
{
    /**
     * Действие, вызываемое при попытке доступа к несуществующему ресурсу.
     * Возвращает JSON-ответ с сообщением об ошибке и статусом 404.
     * @return \Laminas\Stdlib\ResponseInterface JSON-ответ с результатом операции
     */
    public function indexAction()
    {
        return JsonEncode::encode(
            $this->getResponse(),
            ['error' => 'resource was not found'],
            404
        );
    }
}