<?php

namespace byrokrat\id;

/**
 * Create null id objects
 */
class NullIdFactory extends IdFactory
{
    public function createId($raw)
    {
        return new NullId;
    }
}
