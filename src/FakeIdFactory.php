<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\AbstractFactoryDecorator;

/**
 * Create fake id objects from raw id string
 */
class FakeIdFactory extends AbstractFactoryDecorator
{
    protected function createNewInstance(string $raw): IdInterface
    {
        return new FakeId($raw);
    }
}
