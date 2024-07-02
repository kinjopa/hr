<?php

namespace NW\WebService\References\Operations\Notification\Interfaces;

abstract class ReferencesOperation
{
    abstract public function doOperation(): array;
    protected function getRequest($pName)
    {
        return $_REQUEST[$pName] ?? null;
    }
}