<?php

namespace NW\WebService\References\Operations\Notification\Entity;

use NW\WebService\References\Operations\Notification\Entity\Contractor;

final class Employee extends Contractor
{
    /**
     * @param int $id
     * @return self|null
     */
    public static function getById(int $id): ?self
    {
        return new self($id);
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->id;
    }
}