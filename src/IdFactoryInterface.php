<?php

namespace byrokrat\id;

/**
 * The base id factory interface
 */
interface IdFactoryInterface
{
    /**
     * Create ID object from raw id string
     *
     * @throws Exception\UnableToCreateIdException If unable to create id
     */
    public function createId(string $raw): IdInterface;
}
