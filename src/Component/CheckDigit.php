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
 * Helper that defines validateCheckDigit(), getCheckDigit() and setCheckDigit()
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait CheckDigit
{
    /**
     * @var string Stored check digit
     */
    private $checkDigit = '';

    /**
     * Used as a handle to get id
     *
     * @return string
     */
    abstract public function getId();

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
     * Set check digit
     *
     * @param  string $checkDigit
     * @return void
     */
    protected function setCheckDigit($checkDigit)
    {
        $this->checkDigit = $checkDigit;
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
