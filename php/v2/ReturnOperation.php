<?php

namespace NW\WebService\References\Operations\Notification;

use NW\WebService\References\Operations\Notification\Builder\ReturnDataBuilder;
use NW\WebService\References\Operations\Notification\Interfaces\NotificationServiceInterface;
use NW\WebService\References\Operations\Notification\Interfaces\ReferencesOperation;
use NW\WebService\References\Operations\Notification\Interfaces\NotificationValidatorInterface;

final class ReturnOperation extends ReferencesOperation
{
    private $notificationService;
    private $validator;
    private $dataBuilder;

    /**
     * Код отправляет уведомления на СМС или Email при получении новых сообщений, или изменения статуса "Заявки".
     *
     * Проблемы: Нет типизации, нарушение приципов SOLID (явный пример S - весь код в одном методе), проблема с валидацией, Нет обработки request, лишние перменные.
     *
     * @param NotificationServiceInterface $notificationService Сервис для отправки уведомлений.
     * @param NotificationValidatorInterface $validator Валидатор данных для отправки уведомлений.
     * @param ReturnDataBuilder $dataBuilder Билдер данных для отправки уведомлений.
     */
    public function __construct(
        NotificationServiceInterface   $notificationService,
        NotificationValidatorInterface $validator,
        ReturnDataBuilder              $dataBuilder
    )
    {
        $this->notificationService = $notificationService;
        $this->validator = $validator;
        $this->dataBuilder = $dataBuilder;
    }

    /**
     * Метод, выполняющий операцию отправки уведомлений.
     *
     * Логика разделена на отдельные классы для повышения читаемости,
     * тестируемости и возможности повторного использования кода.
     *
     * @return array Результат отправки уведомлений.
     * @throws \NotificationException
     */
    public function doOperation(): array
    {
        try {
            $data = (array)$this->getRequest('data');
            $this->validator->validateDataFields($data);

            $data = $this->dataBuilder->buildData($data);
            $this->validator->validateTemplateData($data->getTemplateData());

            $result = $this->notificationService->sendNotifications(
                $data->getNotificationType(),
                $data->getReseller(),
                $data->getClient(),
                $data->getTemplateData()
            );
        } catch (\NotificationException $e) {
            throw new \NotificationException($e->getMessage(),404);
        }

        return $result;
    }
}
