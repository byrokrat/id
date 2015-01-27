<?php

namespace byrokrat\id;

/**
 * Create organization id objects from raw id string
 */
class OrganizationIdFactory extends IdFactory
{
    use Component\Factory;

    /**
     * Instantiate ID object
     *
     * @param  string $rawId Raw id string
     * @return OrganizationId
     */
    protected function createNewInstance($rawId)
    {
        return new OrganizationId($rawId);
    }
}
