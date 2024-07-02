<?php

namespace NW\WebService\References\Operations\Notification\Services;


use NW\WebService\References\Operations\Notification\Dto\NotificationDto;
use NW\WebService\References\Operations\Notification\Entity\Contractor;
use NW\WebService\References\Operations\Notification\Entity\Seller;
use NW\WebService\References\Operations\Notification\Enums\NotificationTypeEnum;
use NW\WebService\References\Operations\Notification\Interfaces\NotificationServiceInterface;
use NW\WebService\References\Operations\Notification\Notifications\EmailNotification;
use NW\WebService\References\Operations\Notification\Notifications\SmsNotification;
use NW\WebService\References\Operations\Notification\Helpers\NotificationsHelper;

class NotificationService implements NotificationServiceInterface
{
    public function sendNotifications(int $notificationType, Seller $reseller, Contractor $client, array $templateData): array
    {
        $result = [
            'notificationEmployeeByEmail' => false,
            'notificationClientByEmail' => false,
            'notificationClientBySms' => [
                'isSent' => false,
                'message' => '',
            ],
        ];

        $emails =  NotificationsHelper::getEmailsByPermit($reseller->id, 'tsGoodsReturn');
        $emailFrom = NotificationsHelper::getResellerEmailFrom();
        if (!empty($emailFrom) && count($emails) > 0) {
            /*
              @todo Хотелось бы избавится от массива, отправлять майлы реселлеров массивом.
            */
            foreach ($emails as $email) {
                $notificationClient = $this->sendClientEmailNotification($emailFrom, $email, $templateData, $reseller->id);
                if ($notificationClient['isSend']){
                    $result['notificationEmployeeByEmail'] = $notificationClient['isSend'];
                }
            }
        }

        if ($notificationType === NotificationTypeEnum::Change && !empty($data['differences']['to'])) {
            if (!empty($client->email) && $emailFrom) {
                $notificationClient = $this->sendClientEmailNotification($emailFrom, $client->email, $templateData, $reseller->id, (int)$data['differences']['to']);
                $result['notificationClientByEmail'] = $notificationClient['isSend'];
            }

            if (!empty($client->mobile)) {
                $smsNotification = $this->sendClientSmsNotification($reseller->id, $client->id, (int)$data['differences']['to'], $templateData);
                $result['notificationClientBySms']['isSent'] = $smsNotification['isSend'];
                $result['notificationClientBySms']['message'] = $smsNotification['message'];
            }
        }

        /*
         @todo Добавить логи
         */

        return $result;
    }

    public function sendClientEmailNotification(string $emailFrom, string $emailTo, array $templateData, int $resellerId, ?int $statusId = null): array
    {
        $dto = new NotificationDto($resellerId, $templateData);
        $dto->setEmailFrom($emailFrom);
        $dto->setEmailTo($emailTo);
        $dto->setStatusId($statusId);

        return  (new EmailNotification())->send($dto);
    }

    public function sendClientSmsNotification(int $resellerId, int $clientId, int $statusId, array $templateData): array
    {
        $dto = new NotificationDto($resellerId, $templateData);
        $dto->setClientId($clientId);
        $dto->setStatusId($statusId);

        return  (new SmsNotification())->send($dto);
    }
}