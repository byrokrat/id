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
use itbz\STB\Utils\Modulo10;


/**
 * PlusGiro account number validator
 *
 * @package STB\Banking
 */
class PlusGiro extends AbstractAccount
{

    /**
     * Validate account number structure
     *
     * @param string $nr
     *
     * @return bool
     */
    public function isValidStructure($nr)
    {
        return (boolean)preg_match("/^\d{1,7}-\d$/", $nr);
    }


    /**
     * Validate modulo 10 check digit
     *
     * @param string $clearing
     *
     * @param string $nr
     *
     * @return bool
     */
    public function isValidCheckDigit($clearing, $nr)
    {
        $nr = str_replace('-', '', $nr);
        $modulo = new Modulo10();

        return $modulo->verify($nr);
    }


    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType()
    {
        return "PlusGiro";
    }


    /**
     * Validate clearing number
     *
     * @param string $nr
     *
     * @return bool
     */
    public function isValidClearing($nr)
    {
        return $nr == '0000';
    }


    /**
     * Get account as string
     *
     * @param string $clearing
     *
     * @param string $nr
     *
     * @return string
     */
    protected function tostring($clearing, $nr)
    {
        return $nr;
    }

}
