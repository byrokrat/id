<?php
/**
 * This file is part of the STB package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package STB\Utils
 */

namespace itbz\STB\Utils;

use itbz\STB\Exception\InvalidAmountException;

/**
 * Work with and represent monetary amounts
 *
 * Uses the bcmath extension for arbitrary floating point arithmetic precision
 *
 * @package STB\Utils
 */
class Amount
{
    /**
     * Internal amount
     *
     * @var string
     */
    private $amount;

    /**
     * The number of decimal digits to use
     *
     * @var int
     */
    private $precision;

    /**
     * Substitution map for signal strings
     *
     * @var array
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
     * Work with and represent monetary amounts
     *
     * Note that setting amount from floating point number or integer may lead
     * to a loss of precision. See setInt() and setFloat() respectively.
     *
     * @param string|int|float $amount
     * @param int $precision The number of decimal digits used in calculations
     * and output. If omitted the 'frac_digits' value of the current monetary
     * locale is used (see localeconv() in the PHP documentation).
     *
     * @throws InvalidAmountException if amount is not valid
     *
     * @deprecated Creating new amounts from floats and integers is deprecated.
     * Use setFloat() and setInt() directly instead.
     */
    public function __construct($amount = '0', $precision = null)
    {
        if (is_null($precision)) {
            $locale = localeconv();
            $precision = $locale['frac_digits'];
        }

        $this->setPrecision($precision);

        if (is_int($amount)) {
            $this->setInt($amount);

        } elseif (is_float($amount)) {
            $this->setFloat($amount);

        } elseif (is_string($amount)) {
            $this->setString($amount);

        } else {
            throw new InvalidAmountException("Invalid amount");
        }
    }

    /**
     * Set the number of decimal digits used in calculations and output
     *
     * @param int $precision
     *
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
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * Set amount from integer
     *
     * Note that amount internally is stored as a string. Converting number to
     * string may involve rounding and yield unexpected results. To keep
     * precision use setString() instead.
     *
     * @param float $int
     *
     * @return void
     *
     * @throws InvalidAmountException if float is not an integer
     */
    public function setInt($int)
    {
        if (!is_int($int)) {
            $msg = "Amount must be an integer";
            throw new InvalidAmountException($msg);
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
     * @param float $float
     *
     * @return void
     *
     * @throws InvalidAmountException if float is not a floating point number
     */
    public function setFloat($float)
    {
        if (!is_float($float)) {
            $msg = "Amount must be a floating point number";
            throw new InvalidAmountException($msg);
        }
        $this->amount = sprintf('%F', $float);
    }

    /**
     * Set amount from string
     *
     * @param stringt $str
     *
     * @return void
     *
     * @throws InvalidAmountException if str is not a numerical string
     */
    public function setString($str)
    {
        if ($str === '') {
            $str = '0';
        }

        if (!is_string($str) || !is_numeric($str)) {
            $msg = "Amount must be a numerical string";
            throw new InvalidAmountException($msg);
        }

        $this->amount = $str;
    }

    /**
     * Check if str is a valid signal string
     *
     * @param string $str
     *
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
     * @param string $str
     *
     * @return void
     *
     * @throws InvalidAmountException if amount is not a valid signal string
     */
    public function setSignalString($str)
    {
        if (!$this->isSignalString($str)) {
            $msg = "Amount must be a valid singal string";
            throw new InvalidAmountException($msg);
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
     * @param string $str
     * @param string $point Decimal point character. Replaced with '.' If
     * omitted omitted the 'mon_decimal_point' value of the current monetary
     * locale is used.
     * @param string $sep Group separator. Replaced with the empty string. If
     * omitted omitted the 'mon_thousands_sep' value of the current monetary
     * locale is used.
     *
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
        return (float)round(floatval($this->amount), $this->precision);
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
        return bcadd($this->amount, '0.0', $this->precision);
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
     * @param string $format Format string as accepted by money_format().
     * Defaults to '%!n': national currency format without currency symbol.
     *
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
     * @param Amount $amount
     *
     * @return void
     */
    public function add(Amount $amount)
    {
        $this->amount = bcadd(
            $this->amount,
            $amount->getRawString(),
            $this->precision
        );
    }

    /**
     * Subtract from amount
     *
     * @param Amount $amount
     *
     * @return void
     */
    public function subtract(Amount $amount)
    {
        $this->amount = bcsub(
            $this->amount,
            $amount->getRawString(),
            $this->precision
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
            $this->precision
        );
    }

    /**
     * Check if instance equals amount
     *
     * @param Amount $amount
     *
     * @return bool
     */
    public function equals(Amount $amount)
    {
        return 0 === bccomp(
            $this->amount,
            $amount->getRawString(),
            $this->precision
        );
    }

    /**
     * Check if instance is lesser than amount
     *
     * @param Amount $amount
     *
     * @return bool
     */
    public function isLesserThan(Amount $amount)
    {
        return -1 === bccomp(
            $this->amount,
            $amount->getRawString(),
            $this->precision
        );
    }

    /**
     * Check if instance is greater than amount
     *
     * @param Amount $amount
     *
     * @return bool
     */
    public function isGreaterThan(Amount $amount)
    {
        return 1 === bccomp(
            $this->amount,
            $amount->getRawString(),
            $this->precision
        );
    }
}
