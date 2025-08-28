<?php
// src/Controller/ErrorController.php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Application\Utils\JsonEncode;

class ErrorController extends AbstractActionController
{
    public function indexAction()
    {
        return JsonEncode::encode(
            $this->getResponse(),
            ['error' => 'resource was not found'],
            404
        );
    }
}
