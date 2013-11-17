<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\Banking;

use iio\stb\Utils\Modulo10;

/**
 * NordeaPerson account
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NordeaPerson extends AbstractAccount
{
    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType()
    {
        return "Nordea";
    }

    /**
     * Get account as string
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->getClearing() . ',' . substr($this->getNumber(), strlen($this->getNumber()) - 10);
    }

    /**
     * Get string describing account structure
     *
     * @return string
     */
    protected function getStructure()
    {
        return "/^0{0,2}\d{10}$/";
    }

    /**
     * Validate clearing number
     *
     * @return bool
     */
    protected function isValidClearing()
    {
        return $this->getClearing() == 3300 || $this->getClearing() == 3782;
    }

    /**
     * Validate account number check digit
     *
     * @return bool
     */
    protected function isValidCheckDigit()
    {
        return Modulo10::verify(
            substr($this->getNumber(), strlen($this->getNumber()) - 10)
        );
    }
}
