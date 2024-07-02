<?php

namespace NW\WebService\References\Operations\Notification\Validator;

use NW\WebService\References\Operations\Notification\Interfaces\NotificationValidatorInterface;

class NotificationValidator implements NotificationValidatorInterface
{
    public function validateTemplateData(array $templateData): void
    {
        foreach ($templateData as $key => $tempData) {
            if (empty($tempData)) {
                throw new \NotificationException("Template Data ({$key}) is empty!", 500);
            }
        }
    }

    public function validateDataFields(array $data): void
    {
        if (empty($data)){
            throw new \NotificationException("Empty fields in data", 500);
        }

        $requiredFields = [
            'complaintId',
            'resellerId',
            'notificationType',
            'complaintNumber',
            'creatorId',
            'expertId',
            'clientId',
            'consumptionId',
            'consumptionNumber',
            'agreementNumber',
            'date',
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \NotificationException("Field '{$field}' is missing or empty!", 500);
            }
        }
    }
}