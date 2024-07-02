<?php

namespace NW\WebService\References\Operations\Notification\Entity;

final class Status extends Contractor
{
    public $id;
    public $name;

    private static  $statusNames = [
        0 => 'Completed',
        1 => 'Pending',
        2 => 'Rejected',
    ];

    public static function getName(int $id): string
    {
        $a = [
            0 => 'Completed',
            1 => 'Pending',
            2 => 'Rejected',
        ];

        return $a[$id];
    }
}