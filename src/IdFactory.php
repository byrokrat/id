<?php

namespace byrokrat\id;

/**
 * Create ID objects from raw id string
 */
class IdFactory implements IdFactoryInterface
{
    /**
     * @deprecated Will be removed in version 2. Use createId() instead.
     */
    public function create($raw)
    {
        trigger_error(
            'create() is deprecated and will be removed in version 2. Use createId() instead.',
            E_USER_DEPRECATED
        );

        return $this->createId($raw);
    }

    /**
     * Create ID object from raw id string
     *
     * @param  string|null $raw Raw id string
     * @return IdInterface
     * @throws Exception\UnableToCreateIdException If unable to create id
     */
    public function createId(?string $raw): IdInterface
    {
        throw new Exception\UnableToCreateIdException("Unable to create ID for number '{$raw}'");
    }
}
