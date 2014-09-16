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
    public function __tostring();
}
