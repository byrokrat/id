<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Create ID objects from raw id string
 */
class IdFactory implements IdFactoryInterface
{
    public function createId(string $raw): IdInterface
    {
        throw new Exception\UnableToCreateIdException("Unable to create ID for number '{$raw}'");
    }
}
