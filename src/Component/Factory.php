<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

use ledgr\id\IdFactory;
use ledgr\id\Exception;

/**
 * Abstract factory implementation
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Factory
{
    /**
     * @var IdFactory Fallback factory
     */
    private $factory;

    /**
     * Set factory used if this factory fails
     *
     * @param IdFactory $factory
     */
    public function __construct(IdFactory $factory = null)
    {
        $this->factory = $factory ?: new IdFactory;
    }

    /**
     * Create ID object from raw id string
     *
     * @param  string $rawId Raw id string
     * @return \ledgr\id\Id
     */
    public function create($rawId)
    {
        try {
            return $this->createNewInstance($rawId);
        } catch (Exception $e) {
            return $this->factory->create($rawId);
        }
    }

    /**
     * Instantiate ID object
     *
     * @param  string $rawId Raw id string
     * @return \ledgr\id\Id
     */
    abstract protected function createNewInstance($rawId);
}
