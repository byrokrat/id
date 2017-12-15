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
     * @param  string $raw Raw id string
     * @return IdInterface
     */
    protected function createNewInstance($raw)
    {
        return new OrganizationId($raw);
    }
}
