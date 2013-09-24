<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\Banking;

use iio\stb\Exception\InvalidClearingException;
use iio\stb\Exception\InvalidStructureException;
use iio\stb\Exception\InvalidCheckDigitException;

/**
 * Abstract account number
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb
 */
abstract class AbstractAccount
{
    /**
     * @var string Clearing number
     */
    private $clear;

    /**
     * @var string Account number
     */
    private $nr;

    /**
     * Constructor
     *
     * @param  string                     $nr
     * @throws InvalidClearingException   If clearing number is invalid
     * @throws InvalidStructureException  If structure is invalid
     * @throws InvalidCheckDigitException If check digit is invalid
     */
    public function __construct($nr)
    {
        assert('is_string($nr)');

        // Strip spaces from number
        $nr = str_replace(' ', '', $nr);

        // Save clearing and account number
        $arr = explode(',', $nr, 2);
        if (count($arr) == 1) {
            $this->clear = '0000';
            $this->nr = $arr[0];
        } else {
            $this->clear = $arr[0];
            $this->nr = $arr[1];
        }

        // Validate clearing number
        if (strlen($this->clear) != 4
            || !ctype_digit($this->clear)
            || !$this->isValidClearing($this->clear)
        ) {
            $msg = "Invalid clearing number for '$nr'";
            throw new InvalidClearingException($msg);
        }

        // Validate structure
        if (!$this->isValidStructure($this->nr)) {
            $msg = "Invalid account number structre for '$nr'";
            throw new InvalidStructureException($msg);
        }

        // Validate check digit
        if (!$this->isValidCheckDigit($this->clear, $this->nr)) {
            $msg = "Invalid check digit for '$nr'";
            throw new InvalidCheckDigitException($msg);
        }
    }

    /**
     * PHP magic method get string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->tostring($this->clear, $this->nr);
    }

    /**
     * Get account as a 16 digit number
     *
     * Clearing number + x number of ceros + account number
     *
     * @return string
     */
    public function to16()
    {
        // Add starting ceros if they don't exist
        $nr = str_pad($this->nr, 12, '0', STR_PAD_LEFT);

        return $this->clear . $nr;
    }

    /**
     * Get clearing number
     *
     * @return string
     */
    public function getClearing()
    {
        return $this->clear;
    }

    /**
     * Get account number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->nr;
    }

    /**
     * Validate clearing number
     *
     * @param  string $nr
     * @return bool
     */
    abstract public function isValidClearing($nr);

    /**
     * Validate account number structure
     *
     * @param  string $nr
     * @return bool
     */
    abstract public function isValidStructure($nr);

    /**
     * Validate account number check digit
     *
     * @param  string $clearing
     * @param  string $nr
     * @return bool
     */
    abstract public function isValidCheckDigit($clearing, $nr);

    /**
     * Get string describing account type
     *
     * @return string
     */
    abstract public function getType();

    /**
     * Get account as string
     *
     * @param  string $clearing
     * @param  string $nr
     * @return string
     */
    protected function tostring($clearing, $nr)
    {
        return "$clearing,$nr";
    }
}
