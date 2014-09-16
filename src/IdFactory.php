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
 * Create ID object from raw id string
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class IdFactory
{
    /**
     * Create ID object from raw id string
     *
     * @param  string $rawId Raw id string
     * @return void never returns
     * @throws Exception\UnableToCreateIdException Always throws exception
     */
    public function create($rawId)
    {
        throw new Exception\UnableToCreateIdException("Unable to create ID for number '{$rawId}'");
    }
}
