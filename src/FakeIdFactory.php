<?php

namespace byrokrat\id;

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
