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
 * Id formatter
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Formatter
{
    /**
     * A full numeric representation of a year, 4 digits
     */
    const TOKEN_DATE_YEAR_FULL = 'Y';

    /**
     * A two digit representation of a year
     */
    const TOKEN_DATE_YEAR = 'y';

    /**
     * Numeric representation of a month, with leading zeros
     */
    const TOKEN_DATE_MONTH = 'm';

    /**
     * Day of the month, 2 digits with leading zeros
     */
    const TOKEN_DATE_DAY = 'd';

    /**
     * Century part of date, 2 digits
     */
    const TOKEN_DATE_CENTURY = 'C';

    /**
     * Part of serial number before delimiter, 6 digits
     */
    const TOKEN_SERIAL_PRE = 'S';

    /**
     * Part of serial number after delimiter, 3 digits
     */
    const TOKEN_SERIAL_POST = 's';

    /**
     * Date and control string delimiter (- or +)
     */
    const TOKEN_DELIMITER = '-';

    /**
     * Check digit
     */
    const TOKEN_CHECK_DIGIT = 'k';

    /**
     * Escape the following character
     */
    const TOKEN_ESCAPE = '\\';

    /**
     * @var string[] Maps tokens to formatting functions
     */
    static private $tokenMap = [
        self::TOKEN_DATE_CENTURY => 'formatCentury',
        self::TOKEN_SERIAL_PRE => 'formatSerialPre',
        self::TOKEN_SERIAL_POST => 'formatSerialPost',
        self::TOKEN_DELIMITER => 'formatDelimiter',
        self::TOKEN_CHECK_DIGIT => 'formatCheckDigit'
    ];

    /**
     * @var \Closure Formatting function, takes an Id object and returns a string
     */
    private $formatter;

    /**
     * Create formatter from format string
     *
     * @param string $format
     */
    public function __construct($format = '')
    {
        // Register empty formatting function
        $this->formatter = function () {
            return '';
        };

        // Used to track escaping state
        $escape = '';

        foreach (str_split($format) as $token) {
            switch ($escape . $token) {
                case self::TOKEN_DATE_YEAR_FULL:
                case self::TOKEN_DATE_YEAR:
                case self::TOKEN_DATE_MONTH:
                case self::TOKEN_DATE_DAY:
                    $this->registerFormatter(function (Id $id) use ($token) {
                        return $id->getDate()->format($token);
                    });
                    break;
                case self::TOKEN_DATE_CENTURY:
                case self::TOKEN_SERIAL_PRE:
                case self::TOKEN_DELIMITER:
                case self::TOKEN_SERIAL_POST:
                case self::TOKEN_CHECK_DIGIT:
                    $this->registerFormatter([$this, self::$tokenMap[$token]]);
                    break;
                case self::TOKEN_ESCAPE:
                    $escape = $token;
                    break;
                default:
                    $escape = '';
                    $this->registerFormatter(function() use ($token) {
                        return $token;
                    });
            }
        }
    }

    /**
     * Register formatting function
     *
     * Registered function must take an Id object and return a string
     *
     * @param  callable $formatter Formatting function
     * @return void
     */
    public function registerFormatter(callable $formatter)
    {
        $oldFormatter = $this->formatter;
        $this->formatter = function (Id $id) use ($oldFormatter, $formatter) {
            return $oldFormatter($id) . $formatter($id);
        };
    }

    /**
     * Format id using registered formatting functions
     *
     * @param  Id $id 
     * @return string
     */
    public function format(Id $id)
    {
        $formatter = $this->formatter;
        return $formatter($id);
    }

    /**
     * Format function for century
     *
     * @param  Id $id
     * @return string
     */
    static private function formatCentury(Id $id)
    {
        return $id->getCentury();
    }

    /**
     * Format function for serial pre delimiter
     *
     * @param  Id $id
     * @return string
     */
    static private function formatSerialPre(Id $id)
    {
        return $id->getSerialPreDelimiter();
    }

    /**
     * Format function for serial post delimiter
     *
     * @param  Id $id
     * @return string
     */
    static private function formatSerialPost(Id $id)
    {
        return $id->getSerialPostDelimiter();
    }

    /**
     * Format function for delimiter
     *
     * @param  Id $id
     * @return string
     */
    static private function formatDelimiter(Id $id)
    {
        return $id->getDelimiter();
    }

    /**
     * Format function for check digit
     *
     * @param  Id $id
     * @return string
     */
    static private function formatCheckDigit(Id $id)
    {
        return $id->getCheckDigit();
    }
}
