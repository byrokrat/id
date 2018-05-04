<?php

namespace byrokrat\id;

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
