<?php

namespace byrokrat\id;

/**
 * Create coordination id objects from raw id string
 */
class CoordinationIdFactory extends AbstractFactoryDecorator
{
    protected function createNewInstance($raw)
    {
        return new CoordinationId($raw);
    }
}
