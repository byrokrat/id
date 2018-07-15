<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Create null id objects
 */
class NullIdFactory extends IdFactory
{
    public function createId(string $raw): IdInterface
    {
        return new NullId();
    }
}
