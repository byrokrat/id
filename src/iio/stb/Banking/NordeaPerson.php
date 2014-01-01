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

use iio\stb\Utils\Modulo10;

/**
 * NordeaPerson account
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NordeaPerson extends AbstractBankAccount
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
