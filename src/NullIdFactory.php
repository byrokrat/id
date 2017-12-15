<?php

namespace byrokrat\id;

/**
 * Create null id objects
 */
class NullIdFactory extends IdFactory
{
    /**
     * Create ID object
     *
     * @param  string $rawId Ignored for NullId
     * @return IdInterface
     */
    public function create($rawId)
    {
        return new NullId;
    }
}
