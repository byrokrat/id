<?php

namespace byrokrat\id\Component;

use byrokrat\id\Exception\InvalidStructureException;

/**
 * Helper that defines parseStructure()
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
