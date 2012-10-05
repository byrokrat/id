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

use itbz\STB\Exception\InvalidStructureException;

/**
 * Modulo10 calculator
 *
 * @package STB\Utils
 */
class Modulo10
{
    /**
     * Verify that the last digit of nr is a valid check digit
     *
     * @param string $nr
     *
     * @return bool
     *
     * @throws InvalidStructureException  if nr is not numerical
     */
    public function verify($nr)
    {
        // Throw exception if input is invalid
        if (!is_string($nr) || !ctype_digit($nr)) {
            $msg = "Number must consist of characters 0-9";
            throw new InvalidStructureException($msg);
        }
        // Save current check digit
        $check = substr($nr, -1);
        // Remove check digit
        $nr = substr($nr, 0, strlen($nr)-1);

        // Verify check digit
        return $check == $this->getCheckDigit($nr);
    }

    /**
     * Calculate check digit for nr
     *
     * @param string $nr
     *
     * @return string
     *
     * @throws InvalidStructureException if nr is not numerical
     */
    public function getCheckDigit($nr)
    {
        // Throw exception if input is invalid
        if (!is_string($nr) || !ctype_digit($nr)) {
            $msg = "Number must consist of characters 0-9";
            throw new InvalidStructureException($msg);
        }
        $n = 2;
        $sum = 0;
        for ($i=strlen($nr)-1; $i>=0; $i--) {
            $tmp = $nr[$i] * $n;
            ($tmp > 9) ? $sum += 1 + ($tmp % 10) : $sum += $tmp;
            ($n == 2) ? $n = 1 : $n = 2;
        }
        $ceil = $sum;
        while ($ceil % 10 != 0) {
            $ceil++;
        }
        $check = $ceil-$sum;

        return (string)$check;
    }
}
