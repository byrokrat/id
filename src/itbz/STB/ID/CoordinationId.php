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
 * @package STB\ID
 */

namespace itbz\STB\ID;

use itbz\STB\Utils\Modulo10;

/**
 * Swedish coordination id number
 *
 * @package STB\ID
 */
class CoordinationId extends PersonalId
{
    /**
     * Set coordination number
     *
     * A coordination number is like a personal number except that 60 is added
     * to the date of birth.
     *
     * @param string $id
     *
     * @return void
     *
     * @throws InvalidStructureException if structure is invalid
     * @throws InvalidCheckDigitException if check digit is invalid
     */
    public function setId($id)
    {
        assert('is_string($id)');

        // Deduct 60 from dob before setting id
        $split = preg_split("/([-+])/", $id, 2, PREG_SPLIT_DELIM_CAPTURE);
        $id = intval(array_shift($split));
        $id -= 60;
        $id = (string)$id;

        foreach ($split as $part) {
            $id .= $part;
        }

        return parent::setId($id);
    }

    /**
     * Get id
     *
     * Year represented using two digits
     *
     * @return string
     */
    public function getId()
    {
        $dob = intval($this->date->format('ymd'));
        $dob += 60;

        return $dob . $this->delim . $this->individualNr . $this->check;
    }

    /**
     * To string magic method
     *
     * Year represented using four digits
     *
     * @return string
     */
    public function __toString()
    {
        $dob = intval($this->date->format('Ymd'));
        $dob += 60;

        return $dob . $this->delim . $this->individualNr . $this->check;
    }

    /**
     * Calculate check digit
     *
     * @return string
     */
    protected function calcCheckDigit()
    {
        $dob = intval($this->date->format('ymd'));
        $dob += 60;
        $nr = $dob . $this->individualNr;
        $modulo = new Modulo10();

        return $modulo->getCheckDigit($nr);
    }
}
