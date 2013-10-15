<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\Banking;

use iio\stb\Utils\Modulo10;

/**
 * SwedbankTyp2 account number
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class SwedbankTyp2 extends AbstractAccount
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getType()
    {
        return "Swedbank";
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $clearing
     * @param  string $nr
     * @return string
     */
    protected function tostring($clearing, $nr)
    {
        // Remove starting ceros if they exist
        $nr = substr($nr, strlen($nr) - 10);

        return "$clearing,$nr";
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    protected static function isValidClearing($nr)
    {
        return $nr >= 8000 &&  $nr <= 8999;
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    protected static function isValidStructure($nr)
    {
        return (boolean)preg_match("/^0{0,2}\d{2,10}$/", $nr);
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $clearing
     * @param  string $check
     * @return bool
     */
    protected static function isValidCheckDigit($clearing, $check)
    {
        $check = ltrim($check, '0');
        $modulo = new Modulo10();

        return $modulo->verify($check);
    }
}
