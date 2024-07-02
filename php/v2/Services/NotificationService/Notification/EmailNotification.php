<?php

namespace NW\WebService\References\Operations\Notification\Notifications;

use NW\WebService\References\Operations\Notification\Dto\NotificationDto;
use NW\WebService\References\Operations\Notification\Enums\NotificationEnum;
use NW\WebService\References\Operations\Notification\Interfaces\NotificationInterface;

final class EmailNotification implements NotificationInterface
{
    public function send(NotificationDto $data): array
    {
        $messages = [
            0 => [
                'emailFrom' => $data->getEmailFrom(),
                'emailTo' => $data->getEmailTo(),
                'subject' => __('complaintClientEmailSubject', $data->getTemplateData(), $data->getResellerId()),
                'message' => __('complaintClientEmailBody', $data->getTemplateData(), $data->getResellerId()),
            ]
        ];

        $response = MessagesClient::sendMessage($messages, $data->getResellerId(), $data->getStatusId(), NotificationEnum::Change);

        return [
            'isSend' => $response ?? true,
            'message' => ''
        ];
    }

}