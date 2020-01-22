<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Exception\UnableToCreateIdException;

class FailingIdFactory implements IdFactoryInterface
{
    public function createId(string $raw, \DateTimeInterface $atDate = null): IdInterface
    {
        throw new UnableToCreateIdException("Unable to create ID for number '{$raw}'");
    }
}
