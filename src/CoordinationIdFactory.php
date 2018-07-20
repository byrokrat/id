<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Create coordination id objects from raw id string
 */
class CoordinationIdFactory implements IdFactoryInterface
{
    use Helper\IdFactoryDecoratorTrait;

    protected function createNewInstance(string $raw): IdInterface
    {
        return new CoordinationId($raw);
    }
}
