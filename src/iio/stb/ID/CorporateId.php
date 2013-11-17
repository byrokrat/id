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
use iio\stb\Exception\InvalidStructureException;
use iio\stb\Exception\InvalidCheckDigitException;

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
