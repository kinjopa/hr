<?php

namespace NW\WebService\References\Operations\Notification\Interfaces;

use NW\WebService\References\Operations\Notification\Dto\NotificationDto;

interface NotificationInterface
{
    public function send(NotificationDto $data): array;
}