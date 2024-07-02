<?php

namespace NW\WebService\References\Operations\Notification\Entity;

class Contractor
{
    const TYPE_CUSTOMER = 0;
    public $id;
    public $email;
    public $mobile;
    public $type;
    public $name;

    public static function getById(int $resellerId): self
    {
        return new self($resellerId);
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->id;
    }
}