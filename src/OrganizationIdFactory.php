<?php

namespace byrokrat\id;

/**
 * Create organization id objects from raw id string
 */
class OrganizationIdFactory extends AbstractFactoryDecorator
{
    protected function createNewInstance($raw)
    {
        return new OrganizationId($raw);
    }
}
