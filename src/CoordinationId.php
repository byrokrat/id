<?php
/**
 * This file is part of ledgr/id.
 *
 * Copyright (c) 2014 Hannes Forsgård
 *
 * ledgr/id is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ledgr/id is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ledgr/id.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace ledgr\id;

use ledgr\checkdigit\Modulo10;

/**
 * Swedish coordination id number
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class CoordinationId extends PersonalId
{
    /**
     * Swedish coordination id number
     *
     * A coordination number is like a personal number except that 60 is added
     * to the date of birth.
     *
     * @param  string                     $id
     * @throws InvalidStructureException  If structure is invalid
     * @throws InvalidCheckDigitException If check digit is invalid
     */
    public function __construct($id)
    {
        // Deduct 60 from dob before setting id
        $split = preg_split("/([-+])/", $id, 2, PREG_SPLIT_DELIM_CAPTURE);
        $id = intval(array_shift($split)) - 60;

        foreach ($split as $part) {
            $id .= $part;
        }

        return parent::__construct($id);
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return intval($this->getDate()->format('ymd')) + 60
            . $this->getDelimiter()
            . $this->getIndividualNr()
            . $this->getCheckDigit();
    }

    /**
     * Get id as string
     *
     * @return string
     */
    public function __tostring()
    {
        return intval($this->getDate()->format('Ymd')) + 60
            . $this->getDelimiter()
            . $this->getIndividualNr()
            . $this->getCheckDigit();
    }

    /**
     * Calculate check digit
     *
     * @return string
     */
    protected function calcCheckDigit()
    {
        return Modulo10::getCheckDigit(
            intval($this->getDate()->format('ymd')) + 60 . $this->getIndividualNr()
        );
    }
}
