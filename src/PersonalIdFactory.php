<?php

namespace byrokrat\id;

/**
 * Create personal id objects from raw id string
 */
class PersonalIdFactory extends IdFactory
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
        return new PersonalId($raw);
    }
}
