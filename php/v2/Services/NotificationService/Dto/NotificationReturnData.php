<?php

namespace NW\WebService\References\Operations\Notification\Dto;

use \NW\WebService\References\Operations\Notification\Entity\Seller;
use \NW\WebService\References\Operations\Notification\Entity\Contractor;

final class NotificationReturnData
{
    private $notificationType;
    private $reseller;
    private $client;
    private $templateData;

    public function __construct(int $notificationType, Seller $reseller, Contractor $client, array $templateData)
    {
        $this->notificationType = $notificationType;
        $this->reseller = $reseller;
        $this->client = $client;
        $this->templateData = $templateData;
    }

    public function getNotificationType(): int
    {
        return $this->notificationType;
    }

    public function getReseller(): Seller
    {
        return $this->reseller;
    }

    public function getClient(): Contractor
    {
        return $this->client;
    }

    public function getTemplateData(): array
    {
        return $this->templateData;
    }
}