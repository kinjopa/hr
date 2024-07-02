<?php

namespace NW\WebService\References\Operations\Notification\Dto;

final class NotificationDto
{
    private $emailFrom = null;
    private $emailTo = null;
    private $resellerId;
    private $clientId = null;
    private $statusId = null;
    private $templateData;

    public function __construct(int $resellerId, array $templateData)
    {
        $this->resellerId = $resellerId;
        $this->templateData = $templateData;
    }

    public function setEmailFrom(string $emailFrom): self
    {
        $this->emailFrom = $emailFrom;
        return $this;
    }

    public function setEmailTo(string $emailTo): self
    {
        $this->emailTo = $emailTo;
        return $this;
    }

    public function setClientId(int $clientId): self
    {
        $this->clientId = $clientId;
        return $this;
    }

    public function setStatusId(?int $statusId): self
    {
        $this->statusId = $statusId;
        return $this;
    }

    public function getEmailFrom(): ?string
    {
        return $this->emailFrom;
    }

    public function getEmailTo(): ?string
    {
        return $this->emailTo;
    }

    public function getResellerId(): int
    {
        return $this->resellerId;
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function getStatusId(): ?int
    {
        return $this->statusId;
    }

    public function getTemplateData(): array
    {
        return $this->templateData;
    }
}