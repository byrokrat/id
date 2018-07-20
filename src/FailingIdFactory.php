<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Id factory that always fails
 */
class FailingIdFactory implements IdFactoryInterface
{
    public function createId(string $raw): IdInterface
    {
        throw new Exception\UnableToCreateIdException("Unable to create ID for number '{$raw}'");
    }
}
