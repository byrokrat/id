<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\IdInterface;
use byrokrat\id\Exception\InvalidCheckDigitException;

class Modulo10
{
    /**
     * Verify that the last digit of id is a valid modulo 10 check digit
     *
     * @throws InvalidCheckDigitException If check digit is not valid
     */
    public static function validateCheckDigit(IdInterface $id): void
    {
        $number = preg_replace('/[^0-9]/', '', $id->getId());

        if (substr($number, -1) !== self::calculateCheckDigit(substr($number, 0, -1) ?: '')) {
            throw new InvalidCheckDigitException("Invalid check digit in {$id->getId()}");
        }
    }

    private static function calculateCheckDigit(string $number): string
    {
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
