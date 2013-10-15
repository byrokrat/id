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
 * NordeaTyp1A account number validator
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NordeaTyp1A extends AbstractAccount
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getType()
    {
        return "Nordea";
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
            ( $nr >= 1100 &&  $nr <= 1199 )
            || ( $nr >= 1400 &&  $nr <= 2099 )
            || ( $nr >= 3000 &&  $nr <= 3399 && $nr != 3300 )
            || ( $nr >= 3410 &&  $nr <= 3999 && $nr != 3782 )
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
