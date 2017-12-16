<?php

namespace byrokrat\id;

/**
 * Create fake id objects from raw id string
 */
class FakeIdFactory extends AbstractFactoryDecorator
{
    protected function createNewInstance($raw)
    {
        return new FakeId($raw);
    }
}
