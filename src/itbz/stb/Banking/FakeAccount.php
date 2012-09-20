<?php
/**
 * This file is part of the STB package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 *
 * @package STB\Banking
 */
namespace itbz\STB\Banking;


/**
 * Fake account number validator, all is valid
 *
 * @package STB\Banking
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
        return TRUE;
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
        return TRUE;
    }


    /**
     * Validate check digit
     *
     * @param string $clearing
     *
     * @param string $nr
     *
     * @return bool
     */
    public function isValidCheckDigit($clearing, $nr)
    {
        return TRUE;
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
