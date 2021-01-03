<?php

declare(strict_types=1);

namespace byrokrat\id;

class NullIdFactory implements IdFactoryInterface
{
    public function createId(string $raw, \DateTimeInterface $atDate = null): IdInterface
    {
        return new NullId();
    }
}
