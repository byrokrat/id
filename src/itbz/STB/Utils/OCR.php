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
 * @package STB\Utils
 */

namespace itbz\STB\Utils;

use itbz\STB\Exception\InvalidStructureException;
use itbz\STB\Exception\InvalidLengthDigitException;
use itbz\STB\Exception\InvalidCheckDigitException;

/**
 * OCR number generation and validation
 *
 * @package STB\Utils
 */
class OCR
{
    /**
     * Internal ocr representation
     *
     * @var string
     */
    private $ocr = '';

    /**
     * Optionally set ocr at construct. See set().
     *
     * @param string $ocr
     */
    public function __construct($ocr = '')
    {
        if ($ocr) {
            $this->set($ocr);
        }
    }

    /**
     * Set ocr number. Ocr must have a valid check and length digits
     *
     * @param string $ocr
     *
     * @return OCR Instance for chaining
     *
     * @throws InvalidStructureException if ocr is not numerical or longer
     * than 25 digits
     * @throws InvalidLengthDigitException if length digit is invalid
     * @throws InvalidCheckDigitException if check digit is invalid
     */
    public function set($ocr)
    {
        // Validate length
        if (
            !is_string($ocr)
            || !ctype_digit($ocr)
            || strlen($ocr) > 25
            || strlen($ocr) < 2
        ) {
            $msg = "\$ocr must be numeric and contain between 2 and 25 digits";
            throw new InvalidStructureException($msg);
        }
        $arOcr = str_split($ocr);
        $check = array_pop($arOcr);
        $length = array_pop($arOcr);
        $base = implode('', $arOcr);
        // Validate length digit
        if ($length != $this->getLengthDigit($base)) {
            $msg = "Invalid length digit";
            throw new InvalidLengthDigitException($msg);
        }
        // Validate check digit
        $modulo = new Modulo10();
        if ($check != $modulo->getCheckDigit($base.$length)) {
            $msg = "Invalid check digit";
            throw new InvalidCheckDigitException($msg);
        }
        $this->ocr = $ocr;

        return $this;
    }

    /**
     * Get current ocr number
     *
     * @return string
     */
    public function get()
    {
        return $this->ocr;
    }

    /**
     * Get current ocr number
     *
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * Create ocr from number. Check and length digits are appended
     *
     * @param string $nr Numerical string, max 23 digits
     *
     * @return OCR Instance for chaining
     *
     * @throws InvalidStructureException if $nr is invalid
     */
    public function create($nr)
    {
        if (!is_string($nr) || !ctype_digit($nr) || strlen($nr) > 23) {
            $msg = "\$nr must be numeric and contain a maximum of 23 digits";
            throw new InvalidStructureException($msg);
        }
        // Calculate and append length digit
        $nr .= $this->getLengthDigit($nr);
        // Calculate and append check digit
        $modulo = new Modulo10();
        $nr .= $modulo->getCheckDigit($nr);

        return $this->set($nr);
    }

    /**
     * Calculate length digit for string
     *
     * The length of $nr plus 2 is used, to take length and check digits into
     * account.
     *
     * @param $nr
     *
     * @return string
     */
    private function getLengthDigit($nr)
    {
        assert('is_string($nr)');
        $length = strlen($nr);
        $length += 2;
        $length = $length % 10;

        return (string)$length;
    }
}
