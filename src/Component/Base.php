<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

use ledgr\checkdigit\Modulo10;
use ledgr\id\Exception\InvalidCheckDigitException;

/**
 * Helper that defines methods for serial number, delimiter and check digit
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Base
{
    /**
     * @var string Serial number pre delimiter
     */
    protected $serialPre = '000000';

    /**
     * @var string Serial number post delimiter
     */
    protected $serialPost = '000';

    /**
     * @var string Date and control string delimiter (- or +)
     */
    protected $delimiter = '-';

    /**
     * @var string Check digit
     */
    protected $checkDigit = '0';

    /**
     * Get id as string
     *
     * @return string
     */
    public function getId()
    {
        return $this->getSerialPreDelimiter()
            . $this->getDelimiter()
            . $this->getSerialPostDelimiter()
            . $this->getCheckDigit();
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
     * Get part of serial number before delimiter, 6 digits
     *
     * @return string
     */
    public function getSerialPreDelimiter()
    {
        return $this->serialPre;
    }

    /**
     * Get part of serial number after delimiter, 3 digits
     *
     * @return string
     */
    public function getSerialPostDelimiter()
    {
        return $this->serialPost;
    }

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit()
    {
        return $this->checkDigit;
    }

    /**
     * Verify that the last digit of id is a valid check digit
     *
     * @throws InvalidCheckDigitException if check digit is not valid
     * @return void
     */
    protected function validateCheckDigit()
    {
        if (!Modulo10::verify(preg_replace('/[^0-9]/', '', $this->getId()))) {
            throw new InvalidCheckDigitException("Invalid check digit in <{$this->getId()}>");
        }
    }
}
