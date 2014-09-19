<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

/**
 * Create corporate id object from raw id string
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class OrganizationIdFactory extends IdFactory
{
    private $factory;

    public function __construct(IdFactory $factory = null)
    {
        $this->factory = $factory ?: new IdFactory;
    }

    public function create($rawId)
    {
        try {
            return new OrganizationId($rawId);
        } catch (Exception $e) {
            return $this->factory->create($rawId);
        }
    }
}
