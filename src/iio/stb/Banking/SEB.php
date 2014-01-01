<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace iio\stb\Banking;

use iio\stb\Utils\Modulo11;

/**
 * SEB account
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class SEB extends AbstractBankAccount
{
    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType()
    {
        return "SEB";
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
            ( $this->getClearing() >= 5000 && $this->getClearing() <= 5999 )
            || ( $this->getClearing() >= 9120 && $this->getClearing() <= 9124 )
            || ( $this->getClearing() >= 9130 && $this->getClearing() <= 9149 )
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
