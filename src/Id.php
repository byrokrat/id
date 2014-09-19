<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

/**
 * Basic id interface
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface Id
{
    /**
     * Male sex identifier
     */
    const SEX_MALE = 'M';

    /**
     * Female sex identifier
     */
    const SEX_FEMALE = 'F';

    /**
     * Undefined or other sex identifier
     */
    const SEX_UNDEFINED = 'O';

    /**
     * Get id as string
     *
     * @return string
     */
    public function getId();

    /**
     * Get id as string
     *
     * @return string
     */
    public function __tostring();

    /**
     * Format id according to format string
     *
     * @param  string $format
     * @return string
     */
    public function format($format);

    /**
     * Get part of serial number before delimiter, 6 digits
     *
     * @return string
     */
    public function getSerialPreDelimiter();

    /**
     * Get part of serial number after delimiter, 3 digits
     *
     * @return string
     */
    public function getSerialPostDelimiter();

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter();

    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit();

    /**
     * Get birth date
     *
     * @return DateTime
     */
    public function getDate();

    /**
     * Get current age
     *
     * @return int
     */
    public function getAge();

    /**
     * Get century part of date, 2 digits
     *
     * @return string
     */
    public function getCentury();

    /**
     * Get sex as denoted by id
     *
     * @return string One of the sex identifier constants
     */
    public function getSex();

    /**
     * Check if id represents a male
     *
     * @return boolean
     */
    public function isMale();

    /**
     * Check if id represents a female
     *
     * @return boolean
     */
    public function isFemale();

    /**
     * Check if sex not applicable
     *
     * @return boolean
     */
    public function isSexUndefined();
}
