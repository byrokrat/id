<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\Utils;

use iio\stb\Exception\InvalidAmountException;

/**
 * Work with and represent monetary amounts
 *
 * Uses the bcmath extension for arbitrary floating point arithmetic precision
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Amount
{
    /**
     * @var string Internal amount
     */
    private $amount;

    /**
     * @var int The number of decimal digits to use
     */
    private $precision;

    /**
     * @var array Substitution map for signal strings
     */
    private static $signals = array(
        '0' => 'å',
        '1' => 'J',
        '2' => 'K',
        '3' => 'L',
        '4' => 'M',
        '5' => 'N',
        '6' => 'O',
        '7' => 'P',
        '8' => 'Q',
        '9' => 'R',
    );

    /**
     * Constructor
     *
     * Note that setting amount from floating point number or integer may lead
     * to a loss of precision. See setInt() and setFloat() respectively.
     *
     * @param string $amount
     * @param int    $precision The number of decimal digits used in calculations
     */
    public function __construct($amount = '0', $precision = null)
    {
        $this->setString($amount);

        if ($precision) {
            $this->setPrecision($precision);
        }
    }

    /**
     * Set the number of decimal digits used in calculations and output
     *
     * @param  int  $precision
     * @return void
     */
    public function setPrecision($precision)
    {
        assert('is_int($precision)');
        $this->precision = $precision;
    }

    /**
     * Get the number of decimal digits used in calculations and output
     *
     * Can be set using at construct or using setPrecision(). If no precision is
     * specified the 'frac_digits' value of the current monetary locale is used
     * (see localeconv() in the PHP documentation).
     *
     * If the monetary locale is 'C' a precision of 2 is used.
     *
     * @return int
     */
    public function getPrecision()
    {
        if (!isset($this->precision)) {
            $info = localeconv();

            if ('C' == setlocale(LC_MONETARY, 0)) {
                $info['frac_digits'] = 2;
            }

            $this->precision = $info['frac_digits'];
        }

        return $this->precision;
    }

    /**
     * Set amount from integer
     *
     * Note that amount internally is stored as a string. Converting number to
     * string may involve rounding and yield unexpected results. To keep
     * precision use setString() instead.
     *
     * @param  float                  $int
     * @return void
     * @throws InvalidAmountException If $int is not an integer
     */
    public function setInt($int)
    {
        if (!is_int($int)) {
            throw new InvalidAmountException("Amount must be an integer");
        }
        $this->amount = sprintf('%F', $int);
    }

    /**
     * Set amount from floating point number
     *
     * Note that amount internally is stored as a string. Converting number to
     * string may involve rounding and yield unexpected results. To keep
     * precision use setString() instead.
     *
     * @param  float                  $float
     * @return void
     * @throws InvalidAmountException If $float is not a floating point number
     */
    public function setFloat($float)
    {
        if (!is_float($float)) {
            throw new InvalidAmountException("Amount must be a floating point number");
        }
        $this->amount = sprintf('%F', $float);
    }

    /**
     * Set amount from string
     *
     * @param  stringt                $str
     * @return void
     * @throws InvalidAmountException If $str is not a numerical string
     */
    public function setString($str)
    {
        if ($str === '') {
            $str = '0';
        }

        if (!is_string($str) || !is_numeric($str)) {
            throw new InvalidAmountException("Amount must be a numerical string");
        }

        $this->amount = $str;
    }

    /**
     * Check if str is a valid signal string
     *
     * @param  string $str
     * @return bool
     */
    public function isSignalString($str)
    {
        return preg_match("/^\d+(å|[JKLMNOPQR])?$/", $str);
    }

    /**
     * Set amount from signal string
     *
     * Signal strings does not contain a decimal digit separator. Instead the
     * last two digits are always considered decimals. For negative values the
     * last digit is converted to an alphabetic character according to schema:
     * 
     * <code>å: letter is transformed to 0
     * J: 1
     * K: 2
     * L: 3
     * M: 4
     * N: 5
     * O: 6
     * P: 7
     * Q: 8
     * R: 9</code>
     *
     * @param  string                 $str
     * @return void
     * @throws InvalidAmountException If amount is not a valid signal string
     */
    public function setSignalString($str)
    {
        if (!$this->isSignalString($str)) {
            throw new InvalidAmountException("Amount must be a valid singal string");
        }

        if (!is_numeric($str)) {
            $str = str_replace(
                self::$signals,
                array_keys(self::$signals),
                $str
            );
            $str = "-$str";
        }
        $str = preg_replace("/^(-?\d*)(\d\d)$/", "$1.$2", $str, 1);

        $this->setString($str);
    }

    /**
     * Set a locale formatted string
     *
     * @param  string $str
     * @param  string $point Decimal point character. Replaced with '.' If
     *     omitted omitted the 'mon_decimal_point' value of the current monetary
     *     locale is used.
     * @param  string $sep   Group separator. Replaced with the empty string. If
     *     omitted omitted the 'mon_thousands_sep' value of the current monetary
     *     locale is used.
     * @return void
     */
    public function setLocaleString($str, $point = null, $sep = null)
    {
        assert('is_string($str)');

        if (is_null($sep)) {
            $locale = localeconv();
            $sep = $locale['mon_thousands_sep'];
            if (is_null($point)) {
                $point = $locale['mon_decimal_point'];
            }
        }

        assert('is_string($point)');
        assert('is_string($sep)');

        $str = str_replace($point, '.', $str);
        $str = str_replace($sep, '', $str);
        $this->setString($str);
    }

    /**
     * Get amount as float
     *
     * Amount is rounded to the number of decimal digits specified at construct.
     *
     * Note that amount internally is stored as a string. Converting to floating
     * point number may lead to a loss of precision.
     *
     * @return float
     */
    public function getFloat()
    {
        return (float)round(floatval($this->amount), $this->getPrecision());
    }

    /**
     * Get amount as integer
     *
     * Amount is evaluated using intval
     *
     * @return int
     */
    public function getInt()
    {
        return intval($this->amount);
    }

    /**
     * Get amount as a non-locale aware string
     *
     * The number of decimal digits returned is set using setPrecision()
     *
     * @return string
     */
    public function getString()
    {
        return bcadd($this->amount, '0.0', $this->getPrecision());
    }

    /**
     * Get the raw string representation
     *
     * @return string
     */
    public function getRawString()
    {
        return $this->amount;
    }

    /**
     * Locale aware format amount
     *
     * Note that amount is converted to a floating point number before
     * formatting takes place. This may lead to a loss of precision.
     *
     * @param  string $format Format string as accepted by money_format().
     *     Defaults to '%!n': national currency format without currency symbol.
     * @return string
     */
    public function format($format = '%!n')
    {
        assert('is_string($format)');
        return money_format($format, $this->getFloat());
    }

    /**
     * PHP magic function to get amount as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getString();
    }

    /**
     * Get amount as signal string
     *
     * See setSignalString() for a description of signal strings
     *
     * @return string
     */
    public function getSignalString()
    {
        $arAmount = str_split($this->getString());

        // Convert negative values
        if ($arAmount[0] == '-') {
            // Shift off sign
            array_shift($arAmount);
            // Set singal character
            $last = count($arAmount) -1;
            $arAmount[$last] = self::$signals[$arAmount[$last]];
        }

        // Remove decimal digit separator
        return str_replace('.', '', implode('', $arAmount));
    }

    /**
     * Add to amount
     *
     * @param  Amount $amount
     * @return void
     */
    public function add(Amount $amount)
    {
        $this->amount = bcadd(
            $this->amount,
            $amount->getRawString(),
            $this->getPrecision()
        );
    }

    /**
     * Subtract from amount
     *
     * @param  Amount $amount
     * @return void
     */
    public function subtract(Amount $amount)
    {
        $this->amount = bcsub(
            $this->amount,
            $amount->getRawString(),
            $this->getPrecision()
        );
    }

    /**
     * Swap sign of amount
     *
     * @return void
     */
    public function invert()
    {
        $this->amount = bcmul(
            $this->amount,
            '-1',
            $this->getPrecision()
        );
    }

    /**
     * Check if instance equals amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function equals(Amount $amount)
    {
        return 0 === bccomp(
            $this->amount,
            $amount->getRawString(),
            $this->getPrecision()
        );
    }

    /**
     * Check if instance is lesser than amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function isLesserThan(Amount $amount)
    {
        return -1 === bccomp(
            $this->amount,
            $amount->getRawString(),
            $this->getPrecision()
        );
    }

    /**
     * Check if instance is greater than amount
     *
     * @param  Amount $amount
     * @return bool
     */
    public function isGreaterThan(Amount $amount)
    {
        return 1 === bccomp(
            $this->amount,
            $amount->getRawString(),
            $this->getPrecision()
        );
    }
}
