<?php

namespace NW\WebService\References\Operations\Notification\Interfaces;

use NW\WebService\References\Operations\Notification\Entity\Contractor;
use NW\WebService\References\Operations\Notification\Entity\Seller;

interface NotificationServiceInterface
{
    public function sendNotifications(int $notificationType, Seller $reseller, Contractor $client, array $templateData): array;
    public function sendClientEmailNotification(string $emailFrom, string $emailTo, array $templateData, int $resellerId, int $statusId = null): bool;
    public function sendClientSmsNotification(int $resellerId, int $clientId, int $statusId, array $templateData): bool;
    /*public function getLastError(): ?string;*/
}