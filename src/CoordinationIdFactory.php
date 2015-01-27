<?php

namespace byrokrat\id;

/**
 * Create coordination id objects from raw id string
 */
class CoordinationIdFactory extends IdFactory
{
    use Component\Factory;

    /**
     * Instantiate ID object
     *
     * @param  string $rawId Raw id string
     * @return CoordinationId
     */
    protected function createNewInstance($rawId)
    {
        return new CoordinationId($rawId);
    }
}
