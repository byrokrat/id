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
 * Bankgiro account number validator
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb
 */
class Bankgiro extends AbstractAccount
{
    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    public function isValidClearing($nr)
    {
        return ( $nr == '0000' );
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    public function isValidStructure($nr)
    {
        return (boolean)preg_match("/^\d{3,4}-\d{4}$/", $nr);
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
        $nr = str_replace('-', '', $nr);
        $modulo = new Modulo10();

        return $modulo->verify($nr);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getType()
    {
        return "Bankgiro";
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
        return $nr;
    }
}
