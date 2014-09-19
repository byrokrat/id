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
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NullId implements Id
{
    use Component\Date, Component\SexualIdentity, Component\Stringify, Component\Format;

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
     * Get id as set using setString()
     *
     * @return string
     */
    public function getId()
    {
        return self::$str;
    }

    /**
     * Get part of serial number before delimiter, 6 digits
     *
     * @return string
     */
    public function getSerialPreDelimiter()
    {
        return '000000';
    }

    /**
     * Get part of serial number after delimiter, 3 digits
     *
     * @return string
     */
    public function getSerialPostDelimiter()
    {
        return '000';
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
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit()
    {
        return '0';
    }
}
