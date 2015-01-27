<?php

namespace byrokrat\id;

/**
 * Create fake id objects from raw id string
 */
class FakeIdFactory extends IdFactory
{
    use Component\Factory;

    /**
     * Instantiate ID object
     *
     * @param  string $rawId Raw id string
     * @return FakeId
     */
    protected function createNewInstance($rawId)
    {
        return new FakeId($rawId);
    }
}
