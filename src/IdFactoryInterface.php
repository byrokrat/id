<?php

namespace byrokrat\id;

use byrokrat\id\Exception\UnableToCreateIdException;

interface IdFactoryInterface
{
    /**
     * Create ID object from raw id string
     *
     * @param string $raw The raw id to parse
     * @param \DateTimeInterface $atDate Optional date when parsing takes place, defaults to today
     * @throws UnableToCreateIdException If unable to create id
     */
    public function createId(string $raw, \DateTimeInterface $atDate = null): IdInterface;
}
