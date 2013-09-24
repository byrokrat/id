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
 * NordeaTyp1B account number validator
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NordeaTyp1B extends AbstractAccount
{
    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    public function isValidClearing($nr)
    {
        return $nr >= 4000 &&  $nr <= 4999;
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    public function isValidStructure($nr)
    {
        return (boolean)preg_match("/^0{0,5}\d{7}$/", $nr);
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $clearing
     * @param  string $nr
     * @return bool
     */
    public function isValidCheckDigit($clearing, $nr)
    {
        $nr = substr($nr, strlen($nr) - 7);
        $modulo = new Modulo11();

        return $modulo->verify($clearing . $nr);
    }

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
}
