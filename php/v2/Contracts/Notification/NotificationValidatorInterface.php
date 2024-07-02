<?php

namespace NW\WebService\References\Operations\Notification\Interfaces;

interface NotificationValidatorInterface
{
    public function validateTemplateData(array $templateData): void;
    public function validateDataFields(array $data): void;
}