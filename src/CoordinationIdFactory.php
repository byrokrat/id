<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\AbstractFactoryDecorator;

/**
 * Create coordination id objects from raw id string
 */
class CoordinationIdFactory extends AbstractFactoryDecorator
{
    protected function createNewInstance(string $raw): IdInterface
    {
        return new CoordinationId($raw);
    }
}
