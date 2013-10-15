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
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Bankgiro extends AbstractAccount
{
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

    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    protected static function isValidClearing($nr)
    {
        return ($nr == '0000');
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $nr
     * @return bool
     */
    protected static function isValidStructure($nr)
    {
        return (boolean)preg_match("/^\d{3,4}-\d{4}$/", $nr);
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
        $check = str_replace('-', '', $check);
        $modulo = new Modulo10();

        return $modulo->verify($check);
    }
}
