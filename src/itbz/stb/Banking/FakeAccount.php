<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb\Banking
 */

namespace itbz\stb\Banking;

/**
 * Fake account number validator, all is valid
 *
 * @package stb\Banking
 */
class FakeAccount extends AbstractAccount
{
    /**
     * Validate clearing number
     *
     * @param string $nr
     *
     * @return bool
     */
    public function isValidClearing($nr)
    {
        return true;
    }

    /**
     * Validate account number structure
     *
     * @param string $nr
     *
     * @return bool
     */
    public function isValidStructure($nr)
    {
        return true;
    }

    /**
     * Validate check digit
     *
     * @param string $clearing
     * @param string $nr
     *
     * @return bool
     */
    public function isValidCheckDigit($clearing, $nr)
    {
        return true;
    }

    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType()
    {
        return "Unknown";
    }
}
