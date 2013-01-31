<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\ID;

use iio\stb\Utils\Modulo10;

/**
 * Swedish coordination id number
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb
 */
class CoordinationId extends PersonalId
{
    /**
     * Set coordination number
     *
     * A coordination number is like a personal number except that 60 is added
     * to the date of birth.
     *
     * @param  string                     $id
     * @return void
     * @throws InvalidStructureException  If structure is invalid
     * @throws InvalidCheckDigitException If check digit is invalid
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
        $dob = intval($this->getDate()->format('ymd'));
        $dob += 60;

        return $dob
            . $this->getDelimiter()
            . $this->getIndividualNr()
            . $this->getCheckDigit();
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
        $dob = intval($this->getDate()->format('Ymd'));
        $dob += 60;

        return $dob
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
        $dob = intval($this->getDate()->format('ymd'));
        $dob += 60;
        $nr = $dob . $this->getIndividualNr();
        $modulo = new Modulo10();

        return $modulo->getCheckDigit($nr);
    }
}
