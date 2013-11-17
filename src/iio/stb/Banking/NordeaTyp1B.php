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
 * NordeaTyp1B account
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NordeaTyp1B extends AbstractAccount
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
        return $this->getClearing() >= 4000 &&  $this->getClearing() <= 4999;
    }

    /**
     * Validate account number check digit
     *
     * @return bool
     */
    protected function isValidCheckDigit()
    {
        return Modulo11::verify(
            $this->getClearing() . substr($this->getNumber(), strlen($this->getNumber()) - 7)
        );
    }
}
