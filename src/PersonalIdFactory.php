<?php

declare(strict_types = 1);

namespace byrokrat\id;

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
