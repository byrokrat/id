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
     * @return NullId
     */
    public function create($rawId)
    {
        return new NullId;
    }
}
