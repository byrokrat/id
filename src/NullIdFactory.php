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
 * Create null id objects
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NullIdFactory extends IdFactory
{
    /**
     * Create ID object
     *
     * @param  string $rawId Ignored for NullId
     * @return NullId
     */
    public function create($rawId)
    {
        return new NullId;
    }
}
