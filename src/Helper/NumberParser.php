<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\Exception\InvalidStructureException;

class NumberParser
{
    /**
     * Parse id using regular expression
     *
     * @return string[] Array of matches
     *
     * @throws InvalidStructureException If regular expression does not match
     */
    public static function parse(string $regexp, string $raw): array
    {
        if (!preg_match($regexp, $raw, $matches)) {
            throw new InvalidStructureException("Unable to parse $raw, invalid structure");
        }

        return $matches;
    }
}
