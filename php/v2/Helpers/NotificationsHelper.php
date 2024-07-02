<?php

namespace NW\WebService\References\Operations\Notification\Helpers;

class NotificationsHelper
{
   public static function getEmailsByPermit($resellerId, $event): array
   {
        return ['someemeil@example.com', 'someemeil2@example.com'];
   }
   public static function getResellerEmailFrom(): string
    {
        return 'contractor@example.com';
    }
}