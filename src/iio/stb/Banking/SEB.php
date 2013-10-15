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

use iio\stb\Utils\Modulo11;

/**
 * SEB account number validator
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class SEB extends AbstractAccount
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getType()
    {
        return "SEB";
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
        $nr = substr($nr, strlen($nr) - 7);

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
        return (
            ( $nr >= 5000 &&  $nr <= 5999 )
            || ( $nr >= 9120 &&  $nr <= 9124 )
            || ( $nr >= 9130 &&  $nr <= 9149 )
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    protected static function isValidStructure($nr)
    {
        return (boolean)preg_match("/^0{0,5}\d{7}$/", $nr);
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
        $verify = substr($clearing, 1);
        $check = substr($check, strlen($check) - 7);
        $verify .= $check;
        $modulo = new Modulo11();

        return $modulo->verify($verify);
    }
}
