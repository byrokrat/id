<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Formatter;

use ledgr\id\Id;

/**
 * Basic formatting functions
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait FormattingFunctions
{
    /**
     * @var string[] Maps tokens to formatting functions
     */
    static protected $tokenMap = [
        self::TOKEN_DATE_CENTURY => 'formatCentury',
        self::TOKEN_SERIAL_PRE => 'formatSerialPre',
        self::TOKEN_SERIAL_POST => 'formatSerialPost',
        self::TOKEN_DELIMITER => 'formatDelimiter',
        self::TOKEN_CHECK_DIGIT => 'formatCheckDigit'
    ];

    /**
     * Format function for century
     *
     * @param  Id $id
     * @return string
     */
    static protected function formatCentury(Id $id)
    {
        return $id->getCentury();
    }

    /**
     * Format function for serial pre delimiter
     *
     * @param  Id $id
     * @return string
     */
    static protected function formatSerialPre(Id $id)
    {
        return $id->getSerialPreDelimiter();
    }

    /**
     * Format function for serial post delimiter
     *
     * @param  Id $id
     * @return string
     */
    static protected function formatSerialPost(Id $id)
    {
        return $id->getSerialPostDelimiter();
    }

    /**
     * Format function for delimiter
     *
     * @param  Id $id
     * @return string
     */
    static protected function formatDelimiter(Id $id)
    {
        return $id->getDelimiter();
    }

    /**
     * Format function for check digit
     *
     * @param  Id $id
     * @return string
     */
    static protected function formatCheckDigit(Id $id)
    {
        return $id->getCheckDigit();
    }
}
