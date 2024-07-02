<?php

namespace NW\WebService\References\Operations\Notification\Enums;

enum NotificationEnum: string
{
    case New = 'changeReturnStatus';
    case Change = 'newReturnStatus';
}