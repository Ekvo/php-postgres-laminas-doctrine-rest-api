<?php

namespace Application\Entity;

class MessageResponse
{
    public string $message;
    public function __construct( string $msg)
    {
        $this->message = $msg;
    }
}