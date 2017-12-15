<?php

namespace byrokrat\id;

/**
 * Create ID objects from raw id string
 */
class IdFactory
{
    /**
     * Create ID object from raw id string
     *
     * @param  string $rawId Raw id string
     * @return IdInterface
     * @throws Exception\UnableToCreateIdException Always throws exception
     */
    public function create($rawId)
    {
        throw new Exception\UnableToCreateIdException("Unable to create ID for number '{$rawId}'");
    }
}
