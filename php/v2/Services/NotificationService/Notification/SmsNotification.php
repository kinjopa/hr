<?php

namespace NW\WebService\References\Operations\Notification\Notifications;

use NW\WebService\References\Operations\Notification\Dto\NotificationDto;
use NW\WebService\References\Operations\Notification\Enums\NotificationEnum;
use NW\WebService\References\Operations\Notification\Interfaces\NotificationInterface;
use NW\WebService\References\Operations\Notification\NotificationEvents;

final Class SmsNotification implements NotificationInterface
{
    private $lastError = null;

    public function send(NotificationDto $data): array
    {
        $response = NotificationManager::send(
            $data->getResellerId(),
            $data->getClientId(),
            NotificationEnum::Change,
            $data->getStatusId(),
            $data->getTemplateData(),
            $this->lastError
        );

        return [
            'isSend' => $response ?? true,
            'message' => !empty($this->lastError) ? $this->lastError : ''
        ];
    }
}