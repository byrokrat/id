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
 * SwedbankTyp2 account
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class SwedbankTyp2 extends AbstractAccount
{
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
     * @return string
     */
    public function __tostring()
    {
        return $this->getClearing() . ',' . ltrim($this->getNumber(), '0');
    }

    /**
     * Get string describing account structure
     *
     * @return string
     */
    protected function getStructure()
    {
        return "/^0{0,2}\d{2,10}$/";
    }

    /**
     * Validate clearing number
     *
     * @return bool
     */
    protected function isValidClearing()
    {
        return $this->getClearing() >= 8000 && $this->getClearing() <= 8999;
    }

    /**
     * Validate account number check digit
     *
     * @return bool
     */
    protected function isValidCheckDigit()
    {
        return Modulo10::verify(
            ltrim($this->getNumber(), '0')
        );
    }
}
