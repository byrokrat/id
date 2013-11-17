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
 * Abstract giro baseclass
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
abstract class AbstractGiro extends AbstractAccount
{
    /**
     * Get account as string
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->getNumber();
    }

    /**
     * Validate clearing number
     *
     * @return bool
     */
    protected function isValidClearing()
    {
        return ($this->getClearing() == '0000');
    }

    /**
     * Validate account number check digit
     *
     * @return bool
     */
    protected function isValidCheckDigit()
    {
        return Modulo10::verify(
            str_replace('-', '', $this->getNumber())
        );
    }
}
