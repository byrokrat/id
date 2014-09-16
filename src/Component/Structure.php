<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

use ledgr\id\Exception\InvalidStructureException;

/**
 * Helper that defines parseStructure()
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Structure
{
    /**
     * Parse id using regular expression
     *
     * Note that static property $structure must be defined
     *
     * @param  string   $id
     * @return string[] Array of matches
     * @throws InvalidStructureException If regular expression does not match
     */
    static protected function parseStructure($id)
    {
        if (!preg_match(static::$structure, $id, $matches)) {
            throw new InvalidStructureException("Invalid id structure in <$id>");
        }

        return $matches;
    }
}
