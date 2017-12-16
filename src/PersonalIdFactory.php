<?php

namespace byrokrat\id;

/**
 * Create personal id objects from raw id string
 */
class PersonalIdFactory extends AbstractFactoryDecorator
{
    protected function createNewInstance($raw)
    {
        return new PersonalId($raw);
    }
}
