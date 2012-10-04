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
 * @package STB\Banking
 */

namespace itbz\STB\Banking;

use itbz\STB\Utils\Modulo11;

/**
 * SwedbankTyp1 account number validator
 *
 * @package STB\Banking
 */
class SwedbankTyp1 extends AbstractAccount
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
        return $nr >= 7000 &&  $nr <= 7999;
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
        return (boolean)preg_match("/^0{0,5}\d{7}$/", $nr);
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
        $verify = substr($clearing, 1);
        $nr = substr($nr, strlen($nr) - 7);
        $verify .= $nr;
        $modulo = new Modulo11();

        return $modulo->verify($verify);
    }

    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType()
    {
        return "Swedbank";
    }

    /**
     * Get account as string
     *
     * @param string $clearing
     * @param string $nr
     *
     * @return string
     */
    protected function tostring($clearing, $nr)
    {
        // Remove starting ceros if they exist
        $nr = substr($nr, strlen($nr) - 7);

        return "$clearing,$nr";
    }
}
