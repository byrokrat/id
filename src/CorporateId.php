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
use ledgr\id\Exception\InvalidStructureException;
use ledgr\id\Exception\InvalidCheckDigitException;

/**
 * Swedish corporate identity numbers
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class CorporateId implements IdInterface
{
    /**
     * @var string Group number
     */
    private $groupNr;

    /**
     * @var array Serial number in tow parts, pre and post delimiter
     */
    private $serialNr;

    /**
     * @var string Check digit
     */
    private $check;

    /**
     * Set id number
     *
     * @param  string                     $id
     * @throws InvalidStructureException  If structure is invalid
     * @throws InvalidCheckDigitException If check digit is invalid
     */
    public function __construct($id)
    {
        if (!preg_match("/^(\d)(\d{5})[-](\d{3})(\d)$/", $id, $matches)) {
            throw new InvalidStructureException('Corporate ids must use form XXXXXX-XXXX');
        }

        list(, $this->groupNr, $pre, $post, $this->check) = $matches;

        if ($pre[1] < 2) {
            throw new InvalidStructureException('Third digit must be at lest 2');
        }

        $this->serialNr = array($pre, $post);

        if ($this->getCheckDigit() != $this->calcCheckDigit()) {
            throw new InvalidCheckDigitException("Invalid check digit for <$id>");
        }
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->groupNr
            . $this->serialNr[0]
            . $this->getDelimiter()
            . $this->serialNr[1]
            . $this->getCheckDigit();
    }

    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit()
    {
        return $this->check;
    }

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter()
    {
        return '-';
    }


    /**
     * Get id as string
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->getId();
    }

    /**
     * Get string describing corporate group
     *
     * NOTE: this is just a hint and does not conclusively determine the legal
     * status of the corporation
     *
     * @return string
     */
    public function getGroupDescription()
    {
        switch ($this->groupNr) {
            case "2":
                return "Stat, landsting, kommun eller församling";
            case "5":
                return "Aktiebolag";
            case "6":
                return "Enkelt bolag";
            case "7":
                return "Ekonomisk förening";
            case "8":
                return "Ideell förening eller stiftelse";
            case "9":
                return "Handelsbolag, kommanditbolag eller enkelt bolag";
            default:
                return "Okänd";
        }
    }

    /**
     * Calculate check digit
     *
     * @return string
     */
    private function calcCheckDigit()
    {
        return Modulo10::getCheckDigit(
            $this->groupNr . $this->serialNr[0] . $this->serialNr[1]
        );
    }
}
