<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Create organization id objects from raw id string
 */
class OrganizationIdFactory implements IdFactoryInterface
{
    use Helper\IdFactoryDecoratorTrait;

    protected function createNewInstance(string $raw): IdInterface
    {
        return new OrganizationId($raw);
    }
}
