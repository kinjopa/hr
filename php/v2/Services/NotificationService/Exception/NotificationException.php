<?php

final class NotificationException extends RuntimeException
{
    public function __construct(string $message, int $statusCode)
    {
        parent::__construct($message, $statusCode);
    }
}