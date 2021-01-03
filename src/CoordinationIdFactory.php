<?php

declare(strict_types=1);

namespace byrokrat\id;

class CoordinationIdFactory implements IdFactoryInterface
{
    use Helper\IdFactoryDecoratorTrait;

    protected function createNewInstance(string $raw, \DateTimeInterface $atDate = null): IdInterface
    {
        return new CoordinationId($raw, $atDate);
    }
}
