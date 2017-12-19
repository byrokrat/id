<?php

namespace byrokrat\id;

/**
 * Modulo10 checkdigit calculator
 */
class Modulo10
{
    /**
     * Check if the last digit of number is a valid modulo 10 check digit
     *
     * @param  string $number
     * @return bool
     */
    public static function isValid($number)
    {
        return substr($number, -1) === self::calculateCheckDigit(substr($number, 0, -1) ?: '');
    }

    /**
     * Calculate the modulo 10 check digit for number
     *
     * @param  string $number
     * @return string
     * @throws Exception\InvalidStructureException If $number is not numerical
     */
    public static function calculateCheckDigit($number)
    {
        if (!ctype_digit($number)) {
            throw new Exception\InvalidStructureException(
                "Number can only contain numerical characters, found: $number"
            );
        }

        $weight = 2;
        $sum = 0;

        for ($pos=strlen($number)-1; $pos>=0; $pos--) {
            $tmp = $number[$pos] * $weight;
            $sum += ($tmp > 9) ? (1 + ($tmp % 10)) : $tmp;
            $weight = ($weight == 2) ? 1 : 2;
        }

        $ceil = $sum;

        while ($ceil % 10 != 0) {
            $ceil++;
        }

        return (string)($ceil-$sum);
    }
}
