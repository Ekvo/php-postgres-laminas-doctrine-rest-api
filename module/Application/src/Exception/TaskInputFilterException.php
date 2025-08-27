<?php
namespace Application\Exception;

use Throwable;

class TaskInputFilterException extends \Exception
{
    private array $errArr;

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

    function getErrArr(): array
    {
        return $this->errArr;
    }
}