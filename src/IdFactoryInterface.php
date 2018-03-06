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
     * @param  string $raw Raw id string
     * @return IdInterface
     */
    public function createId(?string $raw): IdInterface;
}
