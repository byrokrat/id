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
 * IdInterface null object
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NullId implements IdInterface
{
    /**
     * @var string String returned by getId()
     */
    private static $str = '-';

    /**
     * Set string returned by getId()
     *
     * @param  string $str
     * @return void
     */
    public static function setString($str)
    {
        self::$str = $str;
    }

    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit()
    {
        return '0';
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
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return self::$str;
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
}
