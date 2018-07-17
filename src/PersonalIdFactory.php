<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\AbstractFactoryDecorator;

/**
 * Create personal id objects from raw id string
 */
class PersonalIdFactory extends AbstractFactoryDecorator
{
    protected function createNewInstance(string $raw): IdInterface
    {
        return new PersonalId($raw);
    }
}
