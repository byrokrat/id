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
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
abstract class AbstractAccount implements AccountInterface
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
        $nr = str_replace(' ', '', $nr);

        $arr = explode(',', $nr, 2);
        if (count($arr) == 1) {
            $this->clear = '0000';
            $this->nr = $arr[0];
        } else {
            $this->clear = $arr[0];
            $this->nr = $arr[1];
        }

        if (strlen($this->clear) != 4
            || !ctype_digit($this->clear)
            || !static::isValidClearing($this->clear)
        ) {
            throw new InvalidClearingException("Invalid clearing number for <$nr>");
        }

        if (!static::isValidStructure($this->nr)) {
            throw new InvalidStructureException("Invalid account number structre for <$nr>");
        }

        if (!static::isValidCheckDigit($this->clear, $this->nr)) {
            throw new InvalidCheckDigitException("Invalid check digit for <$nr>");
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function __toString()
    {
        return $this->tostring($this->clear, $this->nr);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     *
     * @return string
     */
    public function getClearing()
    {
        return $this->clear;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->nr;
    }

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

    /**
     * Validate clearing number
     *
     * @param  string $nr
     * @return bool
     */
    protected static function isValidClearing($nr)
    {
        return false;
    }

    /**
     * Validate account number structure
     *
     * @param  string $nr
     * @return bool
     */
    protected static function isValidStructure($nr)
    {
        return false;
    }

    /**
     * Validate account number check digit
     *
     * @param  string $clearing
     * @param  string $check
     * @return bool
     */
    protected static function isValidCheckDigit($clearing, $check)
    {
        return false;
    }
}
