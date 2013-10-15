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
 * Account interface
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface AccountInterface
{
    /**
     * Get account as string
     *
     * @return string
     */
    public function __toString();

    /**
     * Get account as a 16 digit number
     *
     * Clearing number + x number of ceros + account number
     *
     * @return string
     */
    public function to16();

    /**
     * Get clearing number
     *
     * @return string
     */
    public function getClearing();

    /**
     * Get account number
     *
     * @return string
     */
    public function getNumber();

    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType();
}
