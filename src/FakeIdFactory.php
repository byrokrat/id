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
     * @param  string $raw Raw id string
     * @return IdInterface
     */
    protected function createNewInstance($raw)
    {
        return new FakeId($raw);
    }
}
