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
     * @param  string $rawId Raw id string
     * @return PersonalId
     */
    protected function createNewInstance($rawId)
    {
        return new PersonalId($rawId);
    }
}
