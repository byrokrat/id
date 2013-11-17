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

use iio\stb\Utils\Modulo11;

/**
 * NordeaTyp1A account
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NordeaTyp1A extends AbstractAccount
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
        return $this->getClearing() . ',' . substr($this->getNumber(), strlen($this->getNumber()) - 7);
    }

    /**
     * Get string describing account structure
     *
     * @return string
     */
    protected function getStructure()
    {
        return "/^0{0,5}\d{7}$/";
    }

    /**
     * Validate clearing number
     *
     * @return bool
     */
    protected function isValidClearing()
    {
        return (
            ( $this->getClearing() >= 1100 && $this->getClearing() <= 1199 )
            || ( $this->getClearing() >= 1400 && $this->getClearing() <= 2099 )
            || ( $this->getClearing() >= 3000 && $this->getClearing() <= 3399 && $this->getClearing() != 3300 )
            || ( $this->getClearing() >= 3410 && $this->getClearing() <= 3999 && $this->getClearing() != 3782 )
        );
    }

    /**
     * Validate account number check digit
     *
     * @return bool
     */
    protected function isValidCheckDigit()
    {
        return Modulo11::verify(
            substr($this->getClearing(), 1) . substr($this->getNumber(), strlen($this->getNumber()) - 7)
        );
    }
}
