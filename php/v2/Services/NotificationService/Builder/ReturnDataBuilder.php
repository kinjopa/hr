<?php

namespace NW\WebService\References\Operations\Notification\Builder;

use NW\WebService\References\Operations\Notification\Dto\NotificationReturnData;
use NW\WebService\References\Operations\Notification\Entity\Contractor;
use \NW\WebService\References\Operations\Notification\Entity\Employee;
use NW\WebService\References\Operations\Notification\Entity\Status;
use \NW\WebService\References\Operations\Notification\Entity\Seller;
use NotificationException;
use NW\WebService\References\Operations\Notification\Enums\NotificationTypeEnum;

class ReturnDataBuilder
{
    /**
     * Метод, билдит данные для отправки уведомлений.
     *
     * @param array $data Данные из запроса.
     * @return NotificationReturnData Объект с данными для отправки уведомлений.
     */
    public function buildData(array $data): NotificationReturnData
    {
        $reseller = $this->getReseller($data['resellerId']);
        $client = $this->getClient($reseller->id, $data['clientId']);
        $creator = $this->getEmployee($data['creatorId']);
        $expert = $this->getEmployee($data['expertId']);

        $differences = $this->getDifferences((int)$data['notificationType'], $data);

        $templateData = $this->buildTemplateData($data, $creator, $expert, $client, $differences);

        return new NotificationReturnData(
            (int)$data['notificationType'],
            $reseller,
            $client,
            $templateData
        );
    }

    private function getReseller(int $resellerId): Seller
    {
        $reseller = Seller::getById($resellerId);

        if ($reseller === null) {
            throw new NotificationException('Seller not found!', 400);
        }

        return $reseller;
    }

    private function getClient(int $resellerId, int $clientId): Contractor
    {
        $client = Contractor::getById($clientId);

        if ($client === null || $client->type !== Contractor::TYPE_CUSTOMER || $client->Seller->id !== $resellerId) {
            throw new NotificationException('сlient not found!', 400);
        }

        return $client;
    }

    private function getEmployee(int $employeeId): Employee
    {
        $employee = Employee::getById($employeeId);

        if (null === $employee) {
            throw new NotificationException('Employee not found!', 400);
        }

        return $employee;
    }

    private function getDifferences(int $notificationType, array $data): string
    {
        $differences = '';
        if ($notificationType === NotificationTypeEnum::New) {
            $differences = __('NewPositionAdded', null, $data['resellerId']);
        } elseif ($notificationType === NotificationTypeEnum::Change && !empty($data['differences'])) {
            $differences = __('PositionStatusHasChanged', [
                'FROM' => Status::getName((int)$data['differences']['from']),
                'TO' => Status::getName((int)$data['differences']['to']),
            ], $data['resellerId']);
        }

        return $differences;
    }

    private function buildTemplateData(array $data, Employee $creator, Employee $expert, Contractor $client, string $differences): array
    {
        $cFullName = $client->getFullName();
        if (empty($client->getFullName())) {
            $cFullName = $client['name'];
        }

        return [
            'COMPLAINT_ID' => (int)$data['complaintId'],
            'COMPLAINT_NUMBER' => (string)$data['complaintNumber'],
            'CREATOR_ID' => (int)$data['creatorId'],
            'CREATOR_NAME' => $creator->getFullName(),
            'EXPERT_ID' => (int)$data['expertId'],
            'EXPERT_NAME' => $expert->getFullName(),
            'CLIENT_ID' => (int)$data['clientId'],
            'CLIENT_NAME' => $cFullName,
            'CONSUMPTION_ID' => (int)$data['consumptionId'],
            'CONSUMPTION_NUMBER' => (string)$data['consumptionNumber'],
            'AGREEMENT_NUMBER' => (string)$data['agreementNumber'],
            'DATE' => (string)$data['date'],
            'DIFFERENCES' => $differences,
        ];
    }
}