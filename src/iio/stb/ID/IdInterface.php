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

/**
 * Id Interface
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface IdInterface
{
    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit();

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter();

    /**
     * Get id
     *
     * @return string
     */
    public function getId();

    /**
     * Get id as string
     *
     * @return string
     */
    public function __toString();
}
